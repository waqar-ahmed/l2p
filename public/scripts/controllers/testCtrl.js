app.controller('testCtrl', function($scope){

	console.log("test controller called");

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


  

});
