var loginApp=angular.module("loginApp",["ajax"]);
loginApp.controller("loginCtrl",["$scope","ajax",function($scope,ajax){
	console.log("hello");
	$scope.login=function(){
		var data={
			id:$scope.id,
			pwd:$scope.pwd
		};
		ajax.post("loginAjax",data,function(data){
			$scope.error=data;
			if(data=="成功"){
				location.href="menu";
			}
		});
	};
}]);