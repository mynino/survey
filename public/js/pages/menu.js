var menuApp=angular.module("menuApp",["ajax"]);
menuApp.controller("menuCtrl",function($scope,ajax){
	$(function(){
		$("nav a").attr({"target":"myframe"});
		$("#logout").click(function(){
			location.href="logoutAjax";
		});
	});
	$("#pwdEditor").on("show.bs.modal",function(){
		$user={};
		$scope.$apply();
	})
	$scope.changePwd=function(){
		if($user.newPwd1==$user.newPwd2){
			var data={
				oldPwd:$scope.$user.oldPwd,
				newPwd:$scope.$user.newPwd1,
			};
			ajax.post("changePwdAjax",data,function(data){
				if(!data){
					$scope.$user.error="密码错误";
				}
				$("#pwdEditor").modal("hide");
			});
		}
	}
});