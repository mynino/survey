
@extends("layouts.main")

@section("head")
<!-- <script type="text/javascript" src="/survey/public/js/pages/dash.js"></script> -->
<script type="text/javascript">
	var qnaireListApp=angular.module("qnaireListApp",["ajax"]);
	qnaireListApp.controller("qnaireListCtrl",["$scope","ajax",function($scope,ajax){
		$scope.$url=basename(window.location.pathname);
		$(function(){
			$("#qnaireList").bootstrapTable({
				url:$scope.$url+"Ajax",
				columns:[{
					field:"id",
					title:"编号"
				},{
					field:"name",
					title:"名称"
				},{
					formatter:operateFormatter
				}],
				search:true,
			});
		});
		function operateFormatter(value,row,index){
			return `<a href="qnaire?id=`+row.id+`">填写</a>`;
		}
	}]);
	
</script>
@stop

@section("body")
<div ng-app="qnaireListApp" ng-controller="qnaireListCtrl">
	<!-- <div>
		<button data-toggle="modal" data-target="#new">新增</button>
		<button data-toggle="modal" data-target="#">重命名</button>
		<button ng-if="$url=='qnaireList'">发布</button>
		<button ng-if="$url!='qnaireList'">取消发布</button>
		<button data-toggle="modal" data-target="#delete">删除</button>
	</div> -->
	<table id="qnaireList">
	</table>
	<!-- 新增modal -->
	<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">新增</h4>
	            </div>
	            <div class="modal-body">名称：<input type="text" name="name"/></div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary">确定</button>
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
	                <button type="button" class="btn btn-primary">确定</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal -->
	</div>
</div>
@stop