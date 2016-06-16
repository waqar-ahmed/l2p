app.controller('coursesCtrl', function($scope,courseService,$location) {

  courseService.getCurrentSem()
		.then(function(res){
			console.log("got all courses from current sem");
			console.log(res.dataSet);
			$scope.courses = res.dataSet;
			console.log("courses:"+$scope.courses);
		}, function(err){
			console.log("Error occured : " + err);
		});



  $scope.defaultSemester = {
        id : '1',
        abbre: 'SS2016',
        name: 'Summer Semester 2016',
      };

  $scope.semesters = [
    {
      id : '1',
      abbre: 'SS2016',
      name: 'Summer Semester 2016',
    },
    {
      id : '2',
      abbre: 'WS2015',
      name: 'Winter Semester 2016',
    },
    {
      id : '3',
      abbre: 'SS2015',
      name: 'Summer Semester 2015',
    },
  ];

  $scope.gotoCourse = function(id,cid){
      console.log("showing single course " + cid);
      $location.path('singlecourse/'+cid);
    }
});
