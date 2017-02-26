<?php

namespace App\Http\Controllers;

use DB,Data,Schema;
use Illuminate\Http\Request;
use App\Question as Question;

class DraftController extends Controller
{
    //
    static function createTable($qnaireId){
    	Schema::create("Draft".$qnaireId,function($table){
    		$table->increments('id');
    		$table->integer('user_id')->nullable();
    		$table->longText('answer')->nullable();
    	});
    }
    static function dropTable($qnaireId){
        if (Schema::hasTable("Draft".$qnaireId)){
    	   Schema::drop("Draft".$qnaireId);
        }
    }
    static function draftDone(){
        self::draftSaveAjax();
        self::analyseStatistics();
    }
    static function draftSaveAjax(){
        $qnaireId=request("id");
        $userId=session("user")->id;
        $data=Data::data();
        $draftModel=DB::table("Draft".$qnaireId)->select("*")->where("user_id",$userId)->first();
        if(is_null($draftModel)){
            DB::table("Draft".$qnaireId)->insert(
                ['user_id' => $userId, 'answer' => json_encode($data)]
            );
        }else{
            // $draftModel->answer=json_encode($data);
            // $draftModel->update(["answer"=>json_encode($data)]);
            DB::table("Draft".$qnaireId)->select("*")->where("user_id",$userId)->update(["answer"=>json_encode($data)]);
        }
    }
    static function draftReadAjax(){
        $qnaireId=request("id");
        $userId=session("user")->id;
        $draft=DB::table("Draft".$qnaireId)->select("answer")->where("user_id",$userId)->first();
        if(!is_null($draft)){
            $data=$draft->answer;
            echo $data;
        }
    }
    static function analyseStatistics(){
        $userId=session("user")->id;
        $answers=Data::data();
        foreach ($answers as $answer) {
            $qModel=Question::find($answer->id);
            $statistics=json_decode($qModel->statistics);
            switch ($answer->type) {
                case '问答':
                    $data=["id"=>$userId,"answer"=>$answer->answer];
                    array_push($statistics, $data);
                    break;
                case '单选':
                    ++$statistics->sum;
                    if(isset($answer->answer)){
                        $value=$answer->answer;
                        ++$statistics->$value;
                    }
                    break;
                case '多选':
                    ++$statistics->sum;
                    foreach ($answer->answer as $key => $value) {
                        ++$statistics->$value;
                    }
                    break;
                case '是非':
                    ++$statistics->sum;
                    $value=$answer->answer;
                    ++$statistics->$value;
                    break;        
                default:
                    # code...
                    break;
            }
            $qModel->statistics=json_encode($statistics);
            $qModel->save();
        }
    }
}
