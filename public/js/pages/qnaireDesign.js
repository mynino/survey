var qnaireDesignApp=angular.module("qnaireDesignApp",["ajax"]);
qnaireDesignApp.controller("qnaireDesignCtrl",["$rootScope","$scope","ajax",function($rootScope,$scope,ajax){
	var id=getRequestParam("id");
	$scope.$qType="是非";
	ajax.get("qnaireReadAjax",{id:id},function(data){
		$scope.$qnaire=data;
		$scope.$questions=data.questions;
	});
	$scope.qnaireSave=function(){
		ajax.post("qnaireSaveAjax",$scope.$qnaire,function(){

		});
	}
	$scope.select=function(question){
		$scope.$question=question;
	};
	$scope.qUp=function(){
		if($scope.$question){
			var index=$scope.$questions.indexOf($scope.$question);
			if(index>0){
				var tmp=$scope.$questions[index-1];
				$scope.$questions[index-1]=$scope.$question;
				$scope.$questions[index]=tmp;
			}
		}
	};
	$scope.qDown=function(){
		if($scope.$question){
			var index=$scope.$questions.indexOf($scope.$question);
			if(index<$scope.$questions.length-1){
				var tmp=$scope.$questions[index+1];
				$scope.$questions[index+1]=$scope.$question;
				$scope.$questions[index]=tmp;
			}
		}
	};
	$scope.qNew=function(){
		var json;
		switch($scope.$qType){
			case "单选":
				json={title:null,type:"单选",items:[]};
				break;
			case "多选":
				json={title:null,type:"多选",items:[]};
				break;
			case "是非":
				json={title:null,type:"是非",items:[0,1]};
				break;
			case "问答":
				json={title:null,type:"问答"};
				break;
		}
		var question={json:json};
		$scope.$questions.push(question);
		$scope.$question=question;
	};
	$scope.qDelete=function(question){
		if(!$scope.$qnaire.delete){
			$scope.$qnaire.delete=[];
		}
		if(question.id){
			$scope.$qnaire.delete.push(question.id);
		}
		$index=$scope.$questions.indexOf(question);
		$scope.$questions.splice($index,1);
	};
}]);
qnaireDesignApp.directive("qdesign",function(){
	return {
		restrict:"E",
		template:`
				<div class="panel panel-default" ng-show="!$question.json.type">
				  	<div class="panel-heading"><input class="form-control" ng-model="$qnaire.name"></input></div>
				  	<div class="panel-body">
				  		<div class="form-group">
							<label>描述</label>
							<textarea class="form-control" ng-model="$qnaire.desc"></textarea>
						</div>
				  	</div>
				</div>
				<div class="panel panel-default" ng-show="$question.json.type">
				  	<div class="panel-heading">{{$question.json.type}}</div>
				  	<div class="panel-body">
				    <!--单选/多选/是非-->
						<div ng-if="$question.json.type=='单选'||$question.json.type=='多选'">
							<div class="form-group">
								<label>标题</label>
								<input class="form-control" ng-model="$question.json.title"/>
							</div>
							<div class="input-group form-group" ng-repeat="item in $question.json.items track by $index">
								<span class="input-group-addon">{{$index+1}}</span>
								<input class="form-control" ng-model="$question.json.items[$index]"/> 
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" ng-click="delete($index)">删除</button>
								</span>
							</div>
							<div class="btn-group">
								<button class="btn btn-default" ng-click="new()">新增</button>
							</div>
						</div>
						<!--问答-->
						<div ng-if="$question.json.type=='问答'||$question.json.type=='是非'">
							<div class="form-group">
								<label>标题</label>
								<input class="form-control" ng-model="$question.json.title"/>
							</div>
						</div>
				  	</div>
				</div>
				`,
		scope:false,
		controller:function($scope){
			$scope.new=function(){
				var items=$scope.$question.json.items;
				items.push(null);
			}
			$scope.delete=function($index){
				$scope.$question.json.items.splice($index,1);
			}
		},
	};
});
