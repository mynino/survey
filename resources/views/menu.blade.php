@extends("layouts.main")

@section("head")
<title>问卷调查系统</title>
<script type="text/javascript" src="/survey/public/js/pages/menu.js"></script>
<style type="text/css">
	html,body,#launch{
		height: 100%;
		width: 100%;
	}
	iframe{
		width:100%;
		height:90%;
		border:0;
	}
</style>
@stop

@section("body")
<div id="launch" ng-app="menuApp" ng-controller="menuCtrl">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<div class="navbar-brand">问卷调查系统</div>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav"> 
					<li class="dropdown">
						<!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">问卷管理<i class="caret"></i></a> -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">问卷管理 <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							@if($user->role=="0")
							<li><a href="qnaireToDo">未完成问卷</a></li>
							@else
							<li><a href="qnaireList">未发布问卷</a></li>
							<li><a href="qnaireDeployedList">已发布问卷</a></li>
							@endif
						</ul>
					</li>
					@if($user->role!="0")
					<li><a href="userList">用户管理</a></li>
					@endif
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
						<div class="dropdown-menu">
							<img src="pic/user.png"/>
							<p class="text-center">{{$user->name}}</p>
							<button data-toggle="modal" data-target="#pwdEditor" class="form-control">修改密码</button>
							<button id="logout" class="form-control">注销</button>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="modal fade" id="pwdEditor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h4 class="modal-title"></h4>
		            </div>
		            <div class="modal-body">
		            	<div class="alert alert-warning" ng-show="$user.error" ng-bing="$user.error"></div>
		            	<div class="form-group">旧密码：<input class="form-control" type="password" name="name" ng-model="$user.oldPwd" required /></div>
		            	<div class="form-group">新密码：<input class="form-control" type="password" name="name" ng-model="$user.newPwd1" required /></div>
		            	<div class="form-group">再次输入：<input class="form-control" type="password" name="name" ng-model="$user.newPwd2" required /></div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		                <button type="button" class="btn btn-primary" ng-click="changePwd()">确定</button>
		            </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal -->
		</div>
	<iframe name="myframe" src="dash" ></iframe>
</div>
@stop