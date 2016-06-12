app.controller('homeCtrl', function($scope, courseService, $location){

	//var REQUEST_USER_CODE = "rest/auth/requestUserCode";
	var LOGIN_USER = "login";
console.log("in home");

	//Checking if user is authenticated or not
	courseService.isUserAuthenticated()
	.then(function(res){
		if(res.Status == true)
		{
			console.log("user is authenticated");
			//getAllCourses();
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
		window.location = LOGIN_USER;
	}

	
});	
