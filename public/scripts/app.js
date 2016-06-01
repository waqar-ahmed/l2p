var app = angular.module('L2pLabApp', ['ngMaterial','ngMdIcons','ui.router','AxelSoft']);


app.config(['$urlRouterProvider', '$stateProvider', function($urlRouterProvider, $stateProvider){
  $urlRouterProvider.otherwise('/');
    $stateProvider
        .state('main', {
            url: '/',
            templateUrl: 'templates/home.html',
            controller: 'homeCtrl'
        })
        .state('courses', {
            url: '/courses',
            templateUrl: 'templates/courses.html',
            controller: 'coursesCtrl'
        })
        .state('previous_semester', {
            url: '/previous',
            templateUrl: 'templates/courses.html',
            controller: 'coursesCtrl'
        })
        .state('singlecourse', {
            url: '/singlecourse/:id',
            templateUrl: 'templates/singlecourse.html',
            controller: 'singlecourseCtrl'
        })

}]);



app.config(function($mdThemingProvider) {
  var customBlueMap = 		$mdThemingProvider.extendPalette('light-blue', {
    'contrastDefaultColor': 'light',
    'contrastDarkColors': ['50'],
	  '100':'00549f',
    '50':'ffffff'
  });
  $mdThemingProvider.definePalette('customBlue', customBlueMap);
  $mdThemingProvider.theme('default')
    .primaryPalette('customBlue', {
      'default': '100',
      'hue-1': '50',
	    'hue-2': '100'
    })
    .accentPalette('pink');
  $mdThemingProvider.theme('input', 'default')
        .primaryPalette('grey')
});

app.service('tempdata', function(){
  var savedata = {};

  var addData = function(inputdata){
    savedata = inputdata;
  }

  var getData = function(){
    return savedata;
  }

  return {addData, getData};
});