// function StringToDom(string){
// 	var container=document.createElement("div");
// 	container.innerHTML=string;
// 	var dom=container.childNodes;
// 	return dom;
// }
/**
	nodelist不是数组是对象，但有length
	dom跟this指向一样
	动态nodelist
*/
'use strict';
var _container,a;
function $DOM(_string){
	var _DOM;
	/*
		初始化
	*/
	(function(){
		var _container=document.createElement("div");
		_container.innerHTML=_string;
		var _childNodes=_container.childNodes;
		_DOM=[];
		for(var i=0;i<_childNodes.length;i++){
			_DOM.push(_childNodes[i]);
		}
		if(!_string){
			_DOM=null; 
		}
	})();
	return{
		string:_string,
		DOM:_DOM,
		append:function(){
			for(var x in this.DOM){
				document.body.append(this.DOM[x])
			}
			// var length=this.DOM.length;
			// for(var i=0;i<length;i++){
			// 	document.body.append(this.DOM[i]);
			// }

			// for(var i=0;i<this.DOM.length;i++){
			// 	 a=this.DOM[i];
			// 	document.body.appendChild(a);
			// }
		},
		remove:function(){
			for(var i=0;i<this.DOM.length;i++){
				DOM[i].remove();
			}
		},
		log:function(){
			console.log(_DOM);
		}
	};
}