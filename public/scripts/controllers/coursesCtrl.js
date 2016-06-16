app.controller('coursesCtrl', function($scope,courseService,$location) {

  courseService.getAllCourses()
		.then(function(res){
			console.log("got all courses from current sem");
			console.log(res.dataSet);
			$scope.courses = res.dataSet;
			console.log("courses:"+$scope.courses);
		}, function(err){
			console.log("Error occured : " + err);
		});



  $scope.selectedSemester = {
        sem: 'ss16',
        name: 'Summer Semester 2016',
      };

  $scope.semesters = [
    {
      sem: 'ss16',
      name: 'Summer Semester 2016',
    },
    {
      sem: 'ws15',
      name: 'Winter Semester 2016',
    },
    {
      sem: 'ss15',
      name: 'Summer Semester 2015',
    },
  ];

  $scope.gotoCourse = function(id,cid){
      console.log("showing single course " + cid);
      $location.path('singlecourse/'+cid);
    }
});
