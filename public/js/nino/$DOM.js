function StringToDom(string){
	var container=document.createElement("div");
	container.innerHTML=string;
	return container;
}
/**
	nodelist不是数组是对象，但有length
	dom跟this指向一样
	动态nodelist
	this取决于调用方式
*/
'use strict';
var _container,a;
function $DOM(string){
	/*
		初始化
	*/
	var that=this;
	(function (){
		var _container=document.createElement("div");
		_container.innerHTML=string;
		var _childNodes=_container.childNodes;
		var _DOM=[];
		if(!string){
			_DOM=null; 
		}else{
			for(var i=0;i<_childNodes.length;i++){
				_DOM.push(_childNodes[i]);
			}
		}
		that.DOM=_DOM;
	})();
	/*
		变量
	*/
	
	this.string=string;
	this.append=function(){
		for(var x in this.DOM){
			document.body.appendChild(this.DOM[x])
		}
	};
	this.remove=function(){
		for(var i=0;i<this.DOM.length;i++){
				this.DOM[i].remove();
			}
	};
}