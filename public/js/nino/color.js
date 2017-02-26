// function colorGenerator(){
// 	return '#'+(Math.random()*0xffffff<<0).toString(16);
// }
// function colorArray(num){
// 	var array=[];
// 	for(i=0;i<num;i++){
// 		var tmp=colorGenerator();
// 		while(array.indexOf(tmp)!=-1){
// 			tmp=colorGenerator();
// 		}
// 		array.push(tmp);
// 	}
// 	return array;
// }
function getColor(){  
    var colorElements = "0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f";  
    var colorArray = colorElements.split(",");  
    var color ="#";  
    for(var i =0;i<6;i++){  
        color+=colorArray[Math.floor(Math.random()*16)];  
    }  
    return color;  
} 
function colorArray(num){
	var array=[];
	for(i=0;i<num;i++){
		var tmp=getColor();
		while(array.indexOf(tmp)!=-1){
			tmp=getColor();
		}
		array.push(tmp);
	}
	return array;
}