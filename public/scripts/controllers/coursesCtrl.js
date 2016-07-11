app.controller('coursesCtrl', function($scope,courseService,$location, $interval, $mdToast,colorService) {

  $scope.coursesLoaded = false;
  $scope.$parent.setNav("L2P - Courses");
  var LOGIN_PAGE = "login.html";

  $scope.selectedSemester = {
        sem: 'ss16',
        name: 'Summer Semester 2016',
      };


  //Checking if user is authenticated or not
  courseService.isUserAuthenticated()
  .then(function(res){
    if(res.Status == true)
    {
      console.log("user is authenticated");
    }
    else{
      //user is not authenticated, therefore we need to redirect user to /requestUserCode page so user can verify application
      //requestUserCode();
      gotoAuthorizePage();
    }
  }, function(err){
    console.log("Error occured : " + err);
  });

  // redirect user to the RWTH authorization page
  gotoAuthorizePage = function(){
    window.location = LOGIN_PAGE;
  }

  courseService.getSortedSems()
    .then(function(res){
		console.log(res);
		if(res.Status === undefined || res.Status == false){
			window.location.reload();
		}
      $scope.semesters = res.Body;
      console.log("got sorted semesters");
      console.log($scope.semesters);
    }, function(err){
      console.log("Error occured : " + err);
	  $mdToast.show(
		$mdToast.simple()
		.textContent("Error occured, please login again!")
		.position('top')
		.hideDelay(1200)
		);
	  courseService.logout();
      window.location = LOGIN_PAGE;

  });

  // get course list from local service
  courseService.getAllCourses()
		.then(function(res){
			console.log(res);
			//error recover
			if(res.Status != true){
				$mdToast.show(
					$mdToast.simple()
					.textContent("Error occured, please login again!")
					.position('top')
					.hideDelay(1200)
				);
				window.location.reload();
			}

			//got all courses therefore generate colors
			$scope.colors = colorService.generateColors(res.dataSet.length);
			$scope.courses = res.dataSet;
			console.log("got all courses");
			console.log("courses:"+$scope.courses);
			$scope.coursesLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
			$scope.coursesLoaded = true;
		});

  // goto course on course click
  $scope.gotoCourse = function(id,cid){
      console.log("showing single course " + cid);
      $location.path('singlecourse/'+cid);
    }

});
