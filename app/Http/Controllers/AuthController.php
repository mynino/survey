<?php

namespace App\Http\Controllers;

use Data,Crypt,Session;
use App\User as User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //
    function userListAjax(){
        $users=User::all();
        echo json_encode($users);
    }
    function createUserAjax(){
        $data=Data::data();
        $userModel=new User();
        if(isset($data->id)){
            $userModel->id=$data->id;
        }
        $userModel->name=$data->name;
        $userModel->pwd=$data->pwd;
        $userModel->role=$data->role;
        // $userModel->id=$data->newId;
        $userModel->save();
    }
    function editUserAjax(){
        $data=Data::data();
        $userModel=User::find($data->id);
        if(isset($data->newId)){
            $userModel->id=$data->newId;
        }
        $userModel->name=$data->name;
        $userModel->pwd=$data->pwd;
        $userModel->role=$data->role;
        $userModel->save();
    }
    function deleteUserAjax(){
        $data=Data::data();
        foreach ($data as $user) {
            $userModel=User::find($user->id)->delete();
        }
    }
    function changePwdAjax(){
        $data=Data::data();
        echo var_dump($data);
        $userId=session("user")->id;
        $userModel=User::find($userId);
        if($userModel->pwd==$data->oldPwd){
            $userModel->pwd=$data->newPwd;
            $userModel->save();
            echo "成功";
        }
    }
    public function loginAjax(){
    	$id=Data::get("id");
    	$pwd=Data::get("pwd");
    	$user=User::find($id);
    	// echo var_dump($user);
    	if(!is_null($user)){
    		if($pwd==$user->pwd){
    			echo "成功";
    			session(["user"=>$user]);
    		}else{
    			echo "密码错误";
    		}
    	}else{
    		echo "无该学号";
    	}
    }
    public function logoutAjax(){
    	Session::forget("user");
        return redirect("/");
    }
    public function is_login(){
    	if(Session::has("user")){
    		return true;
    	}else{
    		return false;
    	}
    }
}
