@extends("layouts.main")

@section("head")
<script type="text/javascript" src="/survey/public/js/pages/qnaireDesign.js"></script>
@stop

@section("body")
<div ng-app="qnaireDesignApp" ng-controller="qnaireDesignCtrl">
	<div id="left" class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading" ng-click="select(question)">
			    <h3 class="panel-title">@{{$qnaire.name}}</h3>
			</div>
			<div class="panel-body">
			    <div ng-repeat="question in $questions track by $index" ng-click="select(question)">
					@{{$index+1}} <span>@{{question.json.title}}</span><i class="glyphicon glyphicon-minus" style="float:right" ng-click="qDelete(question)"></i>
				</div>
		  	</div>
		</div>
		<!-- <h4>@{{$qnaire.name}}</h4>
		<div ng-repeat="question in $questions track by $index" ng-click="select(question)">
			@{{$index+1}} <span>@{{question.json.title}}</span><i class="glyphicon glyphicon-minus" style="float:right" ng-click="qDelete(question)"></i>
		</div> -->
		<div class="btn-group">
			<span class="btn btn-default" ng-click="qUp()">上移</span>
			<span class="btn btn-default" ng-click="qDown()">下移</span>
			<span class="btn btn-default" ng-click="qnaireSave()">保存</span>
			<span class="btn-group">
				<button class="btn btn-default" ng-click="qNew();">@{{$qType}}</button>
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<span class="caret"></span>
				</button>
				<ul id="ul" class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><a ng-click="$qType='是非';qNew();">是非</a></li>
					<li><a ng-click="$qType='单选';qNew();">单项</a></li>
					<li><a ng-click="$qType='多选';qNew();">多选</a></li>
					<li><a ng-click="$qType='问答';qNew();">问答</a></li>
				</ul>
			</span>
		</div>
	</div>
	<div id="right" class="col-md-8">
		<qdesign></qdesign>
	</div>
</div>
@stop