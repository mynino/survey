function basename(url){
	var list=url.split("/");
	return list[list.length-1];
}
function getRequestParam(key){
	var result={};
	var params=window.location.search.substring(1);
	var arrs=params.split("&");
	for(var i in arrs){
		var arr=arrs[i].split("=");
		result[arr[0]]=decodeURI(arr[1]);
	}
	return result[key];
}
