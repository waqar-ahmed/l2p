app.service('courseService', ['$http', '$q', function ($http, $q) {

	var courses;
	//var ROOT_URL = "http://localhost/laravel/l2p/public/";

	var URL_AUTHENTICATE = "authenticate";
	var URL_GET_ALL_COURSES = "courses";

	this.isUserAuthenticated = function(){
		var defer = $q.defer();

		$http.get(URL_AUTHENTICATE)
		.success(function(res){
			console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	this.getAllCourses = function(){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_COURSES)
		.success(function(res){
			console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

}]);