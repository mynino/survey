(function(angular){
	'use strict';
	var ajax=angular.module("ajax",[]);
	ajax.service("ajax",function($http){
		this.post=function(url,data,sback,eback){
			$http({
				method:"POST",
				url:url,
				data:data,
				// headers:{ 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(data, status, headers, config){
				if(angular.isFunction(sback))
					sback(data, status, headers, config);
			}).error(function(data, status, headers, config){
				if(angular.isFunction(eback))
					eback(data, status, headers, config);
			});
		};
		this.get=function(url,params,sback,eback){
			$http({
				method:"GET",
				url:url,
				params:params
			}).success(function(data, status, headers, config){
				if(angular.isFunction(sback))
					sback(data, status, headers, config);
			}).error(function(data, status, headers, config){
				if(angular.isFunction(eback))
					eback(data, status, headers, config);
			});
		}
		this.execute=function(url,params){
			$http({
				method:"POST",
				url:url,
				params:params
			});
		}
	});
})(angular)