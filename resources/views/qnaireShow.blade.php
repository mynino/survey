@extends("layouts.main")

@section("head")
<script type="text/javascript" src="/survey/public/js/pages/qnaireShow.js"></script>
@stop

@section("body")
<div class="container"  ng-app="qnaireShowApp" ng-controller="qnaireShowCtrl">
    <div class="jumbotron" ng-show="$qnaire" class="col-md-10 col-md-offset-1">
        <div>
            <h3 class="text-center">@{{$qnaire.name}}</h3>
            <h4 >@{{$qnaire.desc}}</h4>
            <!-- <qshow question="question"></qshow> -->
            <div class="question" questionId="@{{question.id}}" type="@{{question.json.type}}" ng-repeat="question in $qnaire.questions">
                <qshow question="question"></qshow>
            </div>
        </div>
    </div>   
</div>
@stop