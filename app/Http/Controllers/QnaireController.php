<?php

namespace App\Http\Controllers;

use DB,Data;
use App\Question as Question;
use App\Done as Done;
use App\User as User;
use App\Questionnaire as Questionnaire;
use Illuminate\Http\Request;

class QnaireController extends Controller
{
    //
    function createQnaireAjax(){
        $userId=session("user")->id;
    	$qnaireModel=new Questionnaire();
    	$qnaireModel->name=Data::get("name");
        $qnaireModel->user_id=$userId;
    	$qnaireModel->save();
    }
    function deleteQnaireAjax(){
        $qnaires=Data::data();
        foreach ($qnaires as $qnaire) {
            $qnaireModel=Questionnaire::find($qnaire->id)->delete();
            DraftController::dropTable($qnaire->id);
        }
    }
    function deployQnaireAjax(){
        DB::transaction(function(){
            $qnaires=Data::data();
            foreach ($qnaires as $qnaire) {
                $this->qnaireDeploy($qnaire->id);
                DraftController::createTable($qnaire->id);
            }
        });
    }
    function undeployQnaireAjax(){
        DB::transaction(function(){
            $qnaires=Data::data();
            foreach ($qnaires as $qnaire) {
                $this->qnaireUndeploy($qnaire->id);
                DraftController::dropTable($qnaire->id);
            }
        });
    }
    function renameQnaireAjax(){
        $qnaire=Data::data();
        $qnaireModel=Questionnaire::find($qnaire->id);
        $qnaireModel->name=$qnaire->name;
        $qnaireModel->save();
    }
    function qnaireReadAjax(){
    	$id=request("id");
    	$survey=Questionnaire::find($id);
    	$questions=[];
    	if(!is_null($survey)){
    		$qids=json_decode($survey->order);
    		foreach($qids as $qid){
	    		$question=Question::find($qid);
                $question->json=json_decode($question->json);
                $question->statistics=json_decode($question->statistics);
    			array_push($questions,$question);
    		}
	    	$survey->questions=$questions;
	    	echo json_encode($survey);
    	}
    	else{
    		echo "没有该问卷";
    	}
    }
    function qnaireSaveAjax(){
        DB::transaction(function(){
        	$data=Data::data();
        	$qnaireId=$data->id;
        	$qnaireModel=Questionnaire::findOrFail($qnaireId);
        	$deleteIds=isset($data->delete)?$data->delete:[];
        	$questions=$data->questions;
        	$order=[];
        	/*
        		刷新问题
        	*/
        	//删除旧问题	
        	foreach ($deleteIds as $deleteId) {
        		Question::find($deleteId)->delete();
        	}
        	//添加/修改新问题
        	foreach($questions as $question){
        		if(isset($question->id)){
        			$qModel=Question::find($question->id);
        		}
        		else{
        			$qModel=new Question();
        		}
        		$qModel->json=json_encode($question->json);
    			$qModel->save();
    			array_push($order, $qModel->id);
        	}
        	/*
        		刷新问卷
        	*/
        	$qnaireModel->name=$data->name;
            $qnaireModel->desc=$data->desc;
        	$qnaireModel->is_deploy=$data->is_deploy;
        	$qnaireModel->order=json_encode($order);
        	$qnaireModel->save();
        });
    }
    function qnaireDoneAjax(){
        DB::transaction(function(){
            //登记用户已做
            $qnaireId=request("id");
            $userId=session("user")->id;
            $doneModel=new Done();
            $doneModel->user_id=$userId;
            $doneModel->qnaire_id=$qnaireId;
            $doneModel->save();
            //删除用户待做
            $userModel=User::find($userId);
            $tmp=json_decode($userModel->qnaire);
            $index=array_search($qnaireId, $tmp);
            if(!is_bool($index)){
                array_splice($tmp, $index,1);
            }
            $userModel->qnaire=json_encode($tmp);
            $userModel->save();
            //统计 pass
            DraftController::draftDone();
        });
    }
    function qnaireDeploy($qnaireId){
        	// $qnaireId=request("id");
        	$qnaireModel=Questionnaire::find($qnaireId);
        	$qnaireModel->is_deploy=1;
            $questionIds=json_decode($qnaireModel->order);
        	$qnaireModel->save();
            //分派任务到人
            $userModels=User::where("role","0")->get();
            foreach ($userModels as $userModel) {
                $tmp=json_decode($userModel->qnaire);
                array_push($tmp, $qnaireId);
                $userModel->qnaire=json_encode($tmp);
                $userModel->save();
            }
            //设置统计数据
            foreach ($questionIds as $questionId) {
                $qModel=Question::find($questionId);
                $json=json_decode($qModel->json);
                switch ($json->type) {
                    case '问答':
                        $statistics=[];
                        break;
                    case '单选':
                        $statistics=["sum"=>0];
                        foreach ($json->items as $key => $value) {
                            $statistics[$key]=0;
                        }
                        break;
                    case '多选':
                        $statistics=["sum"=>0];
                        foreach ($json->items as $key => $value) {
                            $statistics[$key]=0;
                        }
                        break;
                    case '是非':
                        $statistics=["sum"=>0];
                        foreach ($json->items as $key => $value) {
                            $statistics[$key]=0;
                        }
                        break;
                    default:
                        $statistics="default";
                        break;
                }
                $qModel->statistics=json_encode($statistics);
                $qModel->save();
            }
        // DB::transaction(function(){
        // });
    }
    function qnaireUndeploy($qnaireId){
    	// $qnaireId=request("id");
    	$qnaireModel=Questionnaire::find($qnaireId);
    	$qnaireModel->is_deploy=0;
    	$qnaireModel->save();
        //取消分派
        $userModels=User::where("role","0")->get();
        foreach ($userModels as $userModel) {
            $tmp=json_decode($userModel->qnaire);
            $index=array_search($qnaireId, $tmp);
            if(!is_bool($index)){
                array_splice($tmp, $index,1);
            }
            $userModel->qnaire=json_encode($tmp);
            $userModel->save();
        }
        //清除数据
        $doneModels=Done::where("qnaire_id",$qnaireId)->delete();
    }
    function qnaireDelete(){
    	$qnaireId=request("id");
    	$qnaireModel=Questionnaire::find($deleteId);
    	$qIds=$qnaireModel->order;
    	foreach($qIds as $qId){
    		$qModel=Question::find($qId);
    		$qModel->delete();
    	}
    	$qnaireModel->delete();
    }
    function qnaireListAjax(){
        if(session("user")->role=="admin"){
            $qnaireModels=Questionnaire::where("is_deploy",0)->get();
            echo json_encode($qnaireModels);
            return;
        }
    	$userId=session("user")->id;
    	$qnaireModels=Questionnaire::where("user_id",$userId)->where("is_deploy",0)->get();
    	echo json_encode($qnaireModels);
    }
    function qnaireDeployedListAjax(){
        if(session("user")->role=="admin"){
            $qnaireModels=Questionnaire::where("is_deploy",1)->get();
            echo json_encode($qnaireModels);
            return;
        }
        $userId=session("user")->id;
        $qnaireModels=Questionnaire::where("user_id",$userId)->where("is_deploy",1)->get();
        echo json_encode($qnaireModels);
    }
    function deployedQnaireListAjax(){
    	$userId=session("user")->id;
    	$qnaireModels=Questionnaire::where("user_id","=",$userId)->where("is_deploy","=",1)->get();
    	echo json_encode($qnaireModels);
    }
    function qnaireToDoAjax(){
        $data=[];
        $userId=session("user")->id;
        $userModel=User::find($userId);
        $qnaireIds=json_decode($userModel->qnaire);
        foreach ($qnaireIds as $qnaireId) {
            $qnaireModel=Questionnaire::find($qnaireId);
            if($qnaireModel){
                array_push($data, $qnaireModel);
            }
        }
        echo json_encode($data);
    }
}
