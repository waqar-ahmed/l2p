app.service('courseService', ['$http', '$q', function ($http, $q) {

	var courses;
	//var ROOT_URL = "http://localhost/laravel/l2p/public/";

	var URL_AUTHENTICATE = "authenticate";
	var URL_GET_ALL_COURSES = "courses";
	var URL_GET_COURSE = "course";
	var URL_GET_CURRENTSEM ="current_semester";
	var URL_GET_ALL_EMIALS = "/all_emails";
    var LOGOUT = "logout";
    var URL_SEMESTER = "/semester";
    var URL_GET_LEARNING_MATERIALS = "/all_learning_materials";

    var URL_VIEW_USER_ROLE = "view_user_role";
    var URL_ADD_EMAIL = "/add_email";
	var URL_DELETE_EMAIL = "/delete_email";

	var URL_GET_ALL_COURSE_EVENTS = "all_course_events";

	var URL_GET_ALL_NEWS = "whats_all_new_since";

	var authenticated = true;


	this.isUserAuthenticated = function(){
		var defer = $q.defer();

		$http.get(URL_AUTHENTICATE)
		.success(function(res){
			console.log(res.Status);
			defer.resolve(res);
			if(res.Status){
				authenticated = true;
			}
			else{
				authenticated = false;
			}
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	this.getAuthenticatedValue = function(){
		return authenticated;
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

	this.getCurrentSem = function(sem){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE+ URL_SEMESTER+ "/"+sem)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.getWhatsNew = function(mins){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_NEWS+ "/"+ mins)
		.success(function(res){
			// console.log(res);
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
			console.log(res);
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

    this.getCourseBySem = function(){
		var defer = $q.defer();

		$http.get()
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


            //trigger onFileSelect method on clickUpload button clicked
    this.clickUpload = function(){
        document.getElementById('i_file').click();
    };

     this.onFileSelect = function(file) {
      if(!file) return;
      console.log("in file select");
      console.log(file.name);
      $scope.showProgressBar = true;
      file.upload = Upload.upload({
        url: '/admin/bubblePLE/fileAttachments/rest',
        data: {fileattachment: {filename: file, title: file.name}},
      });

      file.upload.progress(function(evt){
          console.log('percent: ' +parseInt(100.0 * evt.loaded / evt.total));
      });

      file.upload.then(function (response) {
        $timeout(function () {
          file.result = response.data;
          console.log(response);
          $mdToast.show(
                  $mdToast.simple()
                      .textContent('File uploaded successfully')
                      .position('bottom')
                      .hideDelay(3000)
           );
          console.log(response.data.item.filename);

          var filePath = String(response.data.item.filename);
          var res = filePath.split("/files/fileattachment/");
          addFileNode(res[1], filePath);
          $scope.showProgressBar = false;
        });
      }, function (response) {
        if (response.status > 0)
          $scope.errorMsg = response.status + ': ' + response.data;
        console.log("in response");
        console.log(response);
        $mdToast.show(
                  $mdToast.simple()
                      .textContent('Error Uploading file')
                      .position('bottom')
                      .hideDelay(3000)
              );
        $scope.showProgressBar = false;
      }, function (evt) {
        // Math.min is to fix IE which reports 200% sometimes
        file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        console.log(file.progress);
        $scope.progressBarValue = file.progress;
      });
	}

}]);
