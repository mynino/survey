
@extends("layouts.main")

@section("head")
<!-- <script type="text/javascript" src="/survey/public/js/pages/dash.js"></script> -->
<script type="text/javascript">
	var qnaireListApp=angular.module("qnaireListApp",["ajax"]);
	qnaireListApp.controller("qnaireListCtrl",["$scope","ajax",function($scope,ajax){
		$scope.$url=basename(window.location.pathname);
		$scope.$list=$("#qnaireList");
		$scope.$editor=$("#editor");
		$scope.$delete=$("#delete");
		$(function(){
			$("#qnaireList").bootstrapTable({
				url:$scope.$url+"Ajax",
				columns:[{
					checkbox:true,
				},{
					field:"id",
					title:"编号"
				},{
					field:"name",
					title:"名称"
				},{
					formatter:operateFormatter
				}],
				search:true,
				toolbar:"#toolbar",
				pagination:{
					pageSize:10,
				},
			});
		});
		$("#qnaireList").on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table",function(){
			$scope.$selection=$("#qnaireList").bootstrapTable("getAllSelections");
		});
		$("#editor").on("show.bs.modal",function(){
			if($scope.action=="new"){
				$scope.$qnaire={};
			}else{
				$scope.$qnaire=$scope.$selection[0];
			}
			$scope.$apply();
		});
		$scope.editQnaire=function(){
			if($scope.action=="new"){
				ajax.post("createQnaireAjax",$scope.$qnaire,function(){
					success();
				});
			}else{
				ajax.post("renameQnaireAjax",$scope.$qnaire,function(){
					success();
				});
			}

		}
		$scope.deleteQnaire=function(){
			ajax.post("deleteQnaireAjax",$scope.$selection,function(){
				success();
			});
		}
		$scope.deployQnaire=function(){
			ajax.post("deployQnaireAjax",$scope.$selection,function(){
				success();
			});
		}
		$scope.undeployQnaire=function(){
			ajax.post("undeployQnaireAjax",$scope.$selection,function(){
				success();
			});
		}
		function operateFormatter(value,row,index){
			if($scope.$url=="qnaireList"){
				return `<a href="qnaireDesign?id=`+row.id+`">设计</a> `+
				`<a href="qnaireShow?id=`+row.id+`">预览</a>`;
			}
			return `<a href="analyse?id=`+row.id+`">统计</a> `+
			`<a href="qnaireShow?id=`+row.id+`">预览</a>`;
		}
		function success(){
			$scope.$list.bootstrapTable("refresh")
			$scope.$editor.modal("hide");
			$scope.$delete.modal("hide");
		}
		$scope.test=function(){
			console.log($scope.action);
		}
	}]);
	
</script>
@stop

@section("body")
<div ng-app="qnaireListApp" ng-controller="qnaireListCtrl">
	<div id="toolbar">
		<div ng-show="$url=='qnaireList'">
			<button class="btn btn-default" data-toggle="modal" data-target="#editor" ng-click="action='new';test(action)">新增</button>
			<button class="btn btn-default" data-toggle="modal" data-target="#editor" ng-click="action='modify'">重命名</button>
			<button class="btn btn-default" ng-click="deployQnaire()">发布</button>
			<button class="btn btn-default" data-toggle="modal" data-target="#delete">删除</button>
		</div>
		<div ng-show="$url!='qnaireList'">
			<button class="btn btn-default" data-toggle="modal" data-target="#editor" ng-click="action='modify'">重命名</button>
			<button class="btn btn-default" ng-click="undeployQnaire()">取消发布</button>
		</div>
	</div>
	<table id="qnaireList">
	</table>
	<!-- 新增modal -->
	<div class="modal fade" id="editor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" ng-show="action=='new'">新增</h4>
	                <h4 class="modal-title" ng-show="action!='new'">修改</h4>
	            </div>
	            <div class="modal-body">名称：<input type="text" name="name" ng-model="$qnaire.name"/></div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary" ng-click="editQnaire()">确定</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal -->
	</div>
	<!-- 删除modal -->
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title"></h4>
	            </div>
	            <div class="modal-body">确认删除？</div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary" ng-click="deleteQnaire()">确定</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal -->
	</div>
</div>
@stop