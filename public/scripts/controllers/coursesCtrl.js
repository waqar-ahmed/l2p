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
      title: 'L2p Lab development',
    },
    {
      id : '6',
      title: 'Satisfiability Checking',
    }
    
  ];

  $scope.gotoCourse = function(id){
      console.log("showing single course " + id);
      $location.path('/singlecourse/' + id);
    }
});
