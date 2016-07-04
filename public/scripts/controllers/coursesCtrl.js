app.controller('coursesCtrl', function($scope,courseService,$location, $interval, colorService) {

  $scope.coursesLoaded = false;
  $scope.$parent.setNav("L2P - Courses");

  $scope.selectedSemester = {
        sem: 'ss16',
        name: 'Summer Semester 2016',
      };

   console.log($scope.semesters);

  courseService.getSortedSems()
    .then(function(res){
      $scope.semesters = res.Body;
      console.log("got sorted semesters");
      console.log($scope.semesters);
    }, function(err){
      console.log("Error occured : " + err);
  });


  courseService.getAllCourses()
		.then(function(res){
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

  $scope.gotoCourse = function(id,cid){
      console.log("showing single course " + cid);
      $location.path('singlecourse/'+cid);
    }

});
