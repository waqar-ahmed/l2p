app.controller('coursesCtrl', function($scope,$location) {

	$scope.courses = [
    {
      id : '1',
      title: 'Elearning',
    },
	{
      id : '2',
      title: 'Functional Programming',
    },
    {
      id : '3',
      title: 'Software Project Management',
    },
    {
      id : '4',
      title: 'Generative Software Engineering',
    },
    {
      id : '5',
      title: 'L2p Lab Developement',
    },
    {
      id : '6',
      title: 'Satisfiability Checking',
    },
  ];

  $scope.defaultSemester = {
        id : '1',
        abbre: 'SS2016',
        name: 'Courses - Summer Semester 2016',
      };

  $scope.semesters = [
    {
      id : '1',
      abbre: 'SS2016',
      name: 'Courses - Summer Semester 2016',
    },
    {
      id : '2',
      abbre: 'WS2015',
      name: 'Courses - Winter Semester 2016',
    },
    {
      id : '3',
      abbre: 'SS2015',
      name: 'Courses - Summer Semester 2015',
    },
  ];

  $scope.gotoCourse = function(id){
      console.log("showing single course " + id);
      $location.path('/singlecourse/' + id);
    }
});
