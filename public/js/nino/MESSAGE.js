// !(function(){
// 	MESSAGE={
// 		confirm:"",
// 		alert:"",
// 		loading:""
// 	};
// 	function init(){
// 		for(var key in MESSAGE){
// 			MESSAGE[key]=$dom(MESSAGE[key]).
// 		}
// 	}
// 	//close
// 	MESSAGE.close=function(){

// 	};
// })();
var MESSAGE=new (function(){
	//
	var that=this;
	(function(){
		var pattern=
		`<div class='MESSAGE'>
		<m_body></m_body>
		<m_btn></m_btn>
		</div>`;
		that.dom=new $DOM(pattern);
		that.btn1=document.createElement("button");
		that.btn2=document.createElement("button");
		that.btn1.innerText="确定";
		that.btn2.innerText="取消";
	})();
	//
	this.dom;
	this.btn1;
	this.btn2;
	this.confirm=function(string,fun1,fun2){
		if(!string){
			string=null;
		}
		this.dom.DOM[0].getElementsByTagName('m_body')[0].innerHTML=string;
		var m_btn=this.dom.DOM[0].getElementsByTagName('m_btn')[0];
		this.btn1.addEventListener("click",fun1);
		this.btn2.addEventListener("click",fun2);
		m_btn.appendChild(this.btn1);
		m_btn.appendChild(this.btn2);
		this.dom.append();
	};
	this.close=function(){
		this.dom.remove();
	};
	
})();