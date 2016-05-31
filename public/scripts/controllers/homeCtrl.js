app.controller('homeCtrl', function($scope, courseService, $location){

	var REQUEST_USER_CODE = "rest/auth/requestUserCode";

	//Checking if user is authenticated or not
	courseService.isUserAuthenticated()
	.then(function(res){
		if(res == "true")
		{
			console.log("user is authenticated");
			getAllCourses();
		}
		else{
			//user is not authenticated, therefore we need to redirect user to /requestUserCode page so user can verify application
			requestUserCode();
		}
	}, function(err){
		console.log("Error occured : " + err);
	});

	// Redirect user to request user code page so user can verify all courses
	requestUserCode = function(){
		window.location = REQUEST_USER_CODE;
	}

	getAllCourses = function(){
		console.log("getting courses");
		courseService.getAllCourses()
		.then(function(res){
			console.log("got all courses");
			console.log(res);
		}, function(err){
			console.log("Error occured : " + err);
		});
	}



});	