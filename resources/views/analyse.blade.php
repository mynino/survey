@extends("layouts.main")

@section("head")
<script type="text/javascript" src="/survey/public/js/pages/analyse.js"></script>
@stop

@section("body")
<div ng-app="analyseApp" ng-controller="analyseCtrl">
	<div id="left" class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
			    <h3 class="panel-title">@{{$qnaire.name}}</h3>
			</div>
			<div class="panel-body">
			    <div ng-repeat="question in $questions track by $index" ng-click="select(question)">
					@{{$index+1}} <span>@{{question.json.title}}</span>
				</div>
		  	</div>
		</div>
	</div>
	<div id="right" class="col-md-8">
		<qanalyse></qanalyse>
	</div>
</div>
@stop