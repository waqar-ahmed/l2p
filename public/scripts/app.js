var app = angular.module('L2pLabApp', ['ngMaterial','ngMdIcons','ui.router','AxelSoft']);


app.config(['$urlRouterProvider', '$stateProvider', function($urlRouterProvider, $stateProvider){
  $urlRouterProvider.otherwise('/');
    $stateProvider
        .state('main', {
            url: '/',
            templateUrl: 'templates/home.html',
            controller: 'homeCtrl'
        })
        .state('test', {
            url: '/test',
            templateUrl: 'templates/courses.html',
            controller: 'testCtrl'
        })
        .state('courses', {
            url: '/courses',
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
    '50': 'ffffff'
  });
  $mdThemingProvider.definePalette('customBlue', customBlueMap);
  $mdThemingProvider.theme('default')
    .primaryPalette('customBlue', {
      'default': '500',
      'hue-1': '50'
    })
    .accentPalette('pink');
  $mdThemingProvider.theme('input', 'default')
        .primaryPalette('grey')
});
