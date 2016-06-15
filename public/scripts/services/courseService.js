app.service('courseService', ['$http', '$q', function ($http, $q) {

	var courses;
	//var ROOT_URL = "http://localhost/laravel/l2p/public/";

	var URL_AUTHENTICATE = "authenticate";
	var URL_GET_ALL_COURSES = "courses";
	var URL_GET_COURSE = "course";
	var URL_GET_CURRENTSEM ="current_semester";
	var URL_GET_ALL_EMIALS = "/all_emails";
    var LOGOUT = "logout";
    var URL_GET_LEARNING_MATERIALS = "/all_learning_materials";

    var URL_VIEW_USER_ROLE = "view_user_role";
    var URL_ADD_EMAIL = "/add_email";
	var URL_DELETE_EMAIL = "/delete_email";

	var URL_GET_ALL_COURSE_EVENTS = "all_course_events";


	this.isUserAuthenticated = function(){
		var defer = $q.defer();

		$http.get(URL_AUTHENTICATE)
		.success(function(res){
			console.log(res.Status);
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
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.getCurrentSem = function(){
		var defer = $q.defer();

		$http.get(URL_GET_CURRENTSEM)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.getEmailbyid = function(cid){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE + "/" + cid + URL_GET_ALL_EMIALS)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	this.getAllLearningMaterials = function(cid){
		var defer = $q.defer();
		$http.get(URL_GET_COURSE + "/" + cid + URL_GET_LEARNING_MATERIALS)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

    this.logout = function(){
        var defer = $q.defer();

		$http.get(LOGOUT)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.viewUserRole = function(cid){
        var defer = $q.defer();

		$http.get(URL_VIEW_USER_ROLE+ "/"+ cid)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

	this.getAllCourseEvents = function(){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_COURSE_EVENTS)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

    this.addEmail = function(cid, email){

        var defer = $q.defer();
        var content = URL_GET_COURSE+ "/"+ cid+ URL_ADD_EMAIL;

		$http.post(content, email)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.deleteEmail = function(cid, itemId){

    var defer = $q.defer();
    var content = URL_GET_COURSE+ "/"+ cid+ URL_DELETE_EMAIL+ "/"+ itemId;

	$http.get(content)
	.success(function(res){
		// console.log(res);
		defer.resolve(res);
	})
	.error(function(err, status){
		console.log(err);
		defer.reject(err);
	})

	return defer.promise;
    }
}]);
