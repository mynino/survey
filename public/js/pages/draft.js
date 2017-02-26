!(function(){
	var draftApp=angular.module("draftApp",["ajax"]);
	draftApp.service("draftService",function(ajax){
		this.saveDraft=function(){
			// var answers=[];
			var answer=null;
			var questions=$(".question");
			var answers=$.map(questions,function(data,index){
				data=$(data);
				var questionId=data.attr("questionId");
				switch(data.attr("type")){
					case "是非":
						answer=data.find(":checked").val();
						break;
					case "单选":
						answer=data.find(":checked").val();
						break;
					case "多选":
						answer=$.map(data.find(":checked"),function(item){
							return item.value;
						});						
						break;
					case "问答":
						answer=data.find("textarea").val();
						break;
				};
				return {
							id:questionId,
							index:index,
							answer:answer,
							type:data.attr("type")
						};
			});
			ajax.post("draftSaveAjax?id="+getRequestParam("id"),answers,function(data){
				// document.write(data);
			});
		};
		this.loadDraft=function(){
			var params={
				id:getRequestParam("id")
			};
			ajax.get("draftReadAjax",params,function(answers){
				if(answers){
					var questions=$(".question");
					$.each(answers,function(qindex,data){
						var question=$(questions[qindex]);
						if(question.attr("type")==data.type){
							var item=null;
							switch(data.type){
								case "是非":
									var condition="input[value='"+data.answer+"']";
									item=question.find(condition);
									item.prop({"checked":true});
									break;
								case "单选":
									item=question.find("input");
									item[data.answer].checked=true;
									break;
								case "多选":
									item=question.find("input");
									$.each(data.answer,function(i,index){
										item[index].checked=true;
									});					
									break;
								case "问答":
									item=question.find("textarea");
									item.val(data.answer);
									break;
							}
						}
					});
				}
			});
		};
		this.doDraft=function(){
			// var answers=[];
			var answer=null;
			var questions=$(".question");
			var answers=$.map(questions,function(data,index){
				data=$(data);
				var questionId=data.attr("questionId");
				switch(data.attr("type")){
					case "是非":
						answer=data.find(":checked").val();
						break;
					case "单选":
						answer=data.find(":checked").val();
						break;
					case "多选":
						answer=$.map(data.find(":checked"),function(item){
							return item.value;
						});						
						break;
					case "问答":
						answer=data.find("textarea").val()
						break;
				};
				return {
							id:questionId,
							index:index,
							answer:answer,
							type:data.attr("type")
						};
			});
			ajax.post("qnaireDoneAjax?id="+getRequestParam("id"),answers,function(data){
				document.write(data);
			});
		}
	});
})(angular);