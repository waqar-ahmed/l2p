app.controller('homeCtrl', function($scope, courseService){

	console.log("its a home controller");

	courseService.isUserAuthenticated()
	.then(function(res){
		if(res != "true")
		{
			console.log("user is not authenticated"); 
			$scope.requestUserCode();
		}
		$scope.getAllCourses();
	}, function(err){
		console.log("Error occured : " + err);
	});

	$scope.requestUserCode = function(){
		courseService.requestUserCode()
		.then(function(res){
			console.log(res);
		}, function(err){
			console.log("Error occured : " + err);
		});
	}

	$scope.getAllCourses = function(){

	}

});	