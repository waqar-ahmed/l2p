app.controller('coursesCtrl', function($scope,courseService,$location, $interval) {

  $scope.coursesLoaded = false;

  courseService.getAllCourses()
		.then(function(res){
			console.log("got all courses from current sem");
			console.log(res.dataSet);

      //got all courses therefore generate colors
      generateColors(res.dataSet.length);
			$scope.courses = res.dataSet;
			console.log("courses:"+$scope.courses);
      $scope.coursesLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
      $scope.coursesLoaded = true;
		});

   var colors = [
    '#4183D7',
    '#59ABE3',
    '#3498DB',
    '#22A7F0',
    '#1E8BC3',
    '#6BB9F0',
    '#1F3A93',
    '#4B77BE',
    '#5C97BF',
    '#89C4F4',
    '#020360'
   ];

  generateColors = function(length){
    $scope.colors = [];
    for(var i = 0; i < length; i++){
      // $scope.colors[i] = '#'+Math.floor(Math.random()*16777215).toString(16);
      $scope.colors[i] = colors[getRandomInt(0 , colors.length - 1)];
    }
  }

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }


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
