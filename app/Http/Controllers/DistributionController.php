<?php

namespace App\Http\Controllers;

use Schema,Distribution;
use Illuminate\Http\Request;

function createClass($qnaireId){
	$Distribution=<<<heredoc
	class Distribution extends \Illuminate\Database\Eloquent\Model
	{
	    //
	    protected \$table='Distribution$qnaireId';
	}
heredoc;
	$qnaireId=intval($qnaireId);
	eval($Distribution);
}

class DistributionController extends Controller
{
    //
    static function createTable($qnaireId){
    	Schema::create("Distribution".$qnaireId,function($table){
    		$table->increments('id');
    		$table->integer('user_id')->nullable();
    		$table->boolean('is_completed')->default(false);
    		$table->boolean('has_draft')->default(false);
    	});
    }
    static function dropTable($qnaireId){
    	Schema::drop("Distribution".$qnaireId);
    }
    static function test($qnaireId){
    	createClass($qnaireId);
    	$re=Distribution::find(1);
    	echo var_dump($re);
    }
    function saveDraft(){
		$qnaireId=request("id");
    	$hasDraft=request("hasDraft");
    	$userId=session("user")->id;
    	createClass($qnaireId);
    	$dist=Distribution::where("user_id",$userId)->first();
    	$dist->has_draft=boolval($hasDraft);
    	$dist->save();
    }
    function complete(){
    	$qnaireId=request("id");
    	$isCompleted=request("isCompleted");
    	$userId=session("user")->id;
    	createClass($qnaireId);
    	$dist=Distribution::where("user_id",$userId)->first();
    	$dist->is_completed=boolval($isCompleted);
    	$dist->save();
    }
}
