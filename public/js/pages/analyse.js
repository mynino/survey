var analyseApp=angular.module("analyseApp",["ajax"]);
analyseApp.controller("analyseCtrl",["$rootScope","$scope","ajax","$timeout",function($rootScope,$scope,ajax,$timeout){
	var id=getRequestParam("id");
	// var backgroundColor=["#FF6384",
 //                "#36A2EB",
 //                "#FFCE56",
 //                "#FFCE56"];
 	var backgroundColor=colorArray(30);
	var hoverBackground=backgroundColor;
	$scope.$qType="是非";
	$scope.$cType="pie";
	ajax.get("qnaireReadAjax",{id:id},function(data){
		$scope.$qnaire=data;
		$scope.$questions=data.questions;
	});
	$scope.select=function(question){
		$scope.$question=question;
		if(question.json.type!="问答"){
			var labels=[];
			var data=[];
			var length=question.json.items.length;
			for(var i=0;i<length;i++){
				labels.push(question.json.items[i]);
				data.push(question.statistics[i]);
			};
			if(question.json.type=="是非"){
				labels=["F","T"];
			}
			$scope.$cData={
				label:question.json.title,
				data:{
					labels:labels,
					datasets:[{
						data:data,
						backgroundColor:backgroundColor,
					}]
				}
			};
			$timeout(function(){
				$scope.updateChart();
			},500);
		}
	};
	$scope.updateChart=function(){
		$scope.$cData.type=$scope.$cType;
		if($scope.$canvas){
			$scope.$canvas.destroy();
		}
		$scope.$canvas=new Chart("chart",$scope.$cData);
	}
}]);
analyseApp.directive("qanalyse",function(){
	return {
		restrict:"E",
		template:`
				<div class="panel panel-default">
				  	<div class="panel-heading">{{$question.json.type}}</div>
				  	<div class="panel-body">
						<!--单选/多选/是非-->
						<div ng-if="$question.json.type=='单选'||$question.json.type=='多选'||$question.json.type=='是非'">
							<h3>标题:{{$question.json.title}}</h3>
							<div class="btn-group">
								<button ng-click="$parent.$cType='pie';$parent.updateChart();">饼图</button>
								<button ng-click="$parent.$cType='bar';$parent.updateChart();">条形图</button>
							</div>
							<div style="width:40%;height:40%">
								<canvas id="chart" ></canvas>
							</div>
						</div>
						<!--问答-->
						<div ng-if="$question.json.type=='问答'">
							<h3>标题:{{$question.json.title}}</h3>
							<blockquote ng-repeat="statistic in $question.statistics">
								<div>{{statistic.answer}}</div>
								<footer>{{statistic.id}}</footer>
							</blockquote>
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
			$scope.test=function(a){
				console.log(a);
			}
		},
	};
});
