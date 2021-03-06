var qnaireApp=angular.module("qnaireShowApp",["ajax","draftApp"]);
qnaireApp.controller("qnaireShowCtrl",["$scope","ajax","$compile","draftService","$timeout",function($scope,ajax,$compile,draftService,$timeout){
	var id=getRequestParam("id");
	ajax.get("qnaireReadAjax",{id:id},function(data){
		$scope.$qnaire=data;
		$timeout(function(){
			$(".jumbotron *").prop({disabled:true});
		},500);
	});
	$scope.saveDraft=function(){
		draftService.saveDraft();
	};
}]);
qnaireApp.directive("qshow",function(){
	return {
		scope:{
			"question":"=",
		},
		template:`
			<div ng-if="question.json.type=='是非'">
				<div>{{$parent.$parent.$index+1}}.{{question.json.title}}</div>
				<div>
					<input type="radio" name="{{question.id}}" value="1"/>T
					<input type="radio" name="{{question.id}}" value="0"/>F
				</div>
			</div>
			<div ng-if="question.json.type=='单选'">
				<div>{{$parent.$parent.$index+1}}.{{question.json.title}}</div>
				<div ng-repeat="item in question.json.items">
					<input type="radio" name="{{question.id}}" value="{{$index}}"/>{{item}}
				</div>
			</div>
			<div ng-if="question.json.type=='多选'">
				<div>{{$parent.$parent.$index+1}}.{{question.json.title}}</div>
				<div ng-repeat="item in question.json.items">
					<input type="checkbox" value="{{$index}}"/>{{item}}
				</div>
			</div>
			<div ng-if="question.json.type=='问答'">
				<div>{{$parent.$parent.$index+1}}.{{question.json.title}}</div>
				<textarea></textarea>
			</div>
		`,
		controller:function($scope){
			
		}
	};
});