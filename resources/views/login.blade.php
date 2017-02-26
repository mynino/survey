@extends("layouts.main")

@section("head")
<script type="text/javascript" src="/survey/public/js/pages/login.js"></script>
<style type="text/css">
	body{
		background:url(pic/login.jpg);
		background-size: 100%;
	}
	.login{
		background: rgba(255,255,255,0.8);
	}
</style>
@stop

@section("body")
<form class="login" action="returntest" ng-app="loginApp" ng-controller="loginCtrl">
	<h1>问卷调查系统</h1>
	<div class="alert alert-warning" ng-show="error" ng-bind="error"></div>
	<div><span style="width:20%"><b>学号</b></span><input style="width:80%" type="text" name="num" ng-model="id" /></div>
	<div><span style="width:20%"><b>密码</b></span><input style="width:80%" type="password" name="pwd" ng-model="pwd" /></div>
	<!-- {{ csrf_field() }} -->
	<div class="btn btn-default" ng-click="login()"><b>登陆</b></div>
</form>
@stop