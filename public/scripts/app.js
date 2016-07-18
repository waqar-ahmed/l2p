
var app = angular.module('L2pLabApp', ['ui.tree','ngMaterial','ngMdIcons','ui.router','ngSanitize','treeControl','ui.calendar', 'ui.bootstrap','ngFileUpload', 'ngTextTruncate','pascalprecht.translate']);

app.config(['$urlRouterProvider', '$stateProvider','$translateProvider', function($urlRouterProvider, $stateProvider,$translateProvider){

  $urlRouterProvider.otherwise('/');
    $stateProvider
        .state('main', {
            url: '/',
            templateUrl: 'templates/home.html',
            controller: 'homeCtrl'
        })
        .state('courses', {
            url: '/mycourses',
            templateUrl: 'templates/courses.html',
            controller: 'coursesCtrl'
        })
        .state('singlecourse', {
            url: '/singlecourse/:cid',
            templateUrl: 'templates/singlecourse.html',
            controller: 'singlecourseCtrl'
        })
		    .state('schedule', {
            url: '/schedule',
            templateUrl: 'templates/schedule.html',
            controller: 'scheduleCtrl'
        })
        .state('emails', {
            url: '/emails',
            templateUrl: 'templates/emails.html',
            controller: 'emailsCtrl'
        })
        .state('about', {
            url: '/about',
            templateUrl: 'templates/about.html',
            controller: 'aboutCtrl'
        })



    //Localization module for EN and DE.

    $translateProvider.translations('en', {
        'HOME_SUBHEADER': 'Whats New',
        'HOME_SUBHEADER_SELECTBOX': 'Last',
        'DASHBOARD' : 'Dashboard',
        'COURSES'   : 'Courses',
        'INBOX' : 'Inbox',
        'CALENDAR' : 'Calendar',
        'ABOUT' : 'About',
        'SEMESTER' : 'Semester',
        'LEARNING_MATERIAL' : 'Learning Material',
        'SHARED_DOCUMENTS' : 'Shared Documents',
        'ASSIGN' : 'Assignments',
        'DISCUSSION' : 'Discussion Forum',
        'EMAILS' : 'Emails',
        'ANNOUNCEMENTS' : 'Announcements',
        'NOTHING' : 'Nothing to show',
        'NO_RECENT' : 'No recent to show'

    });
 
        $translateProvider.translations('de', {
        'HOME_SUBHEADER': 'asdasd',
        'HOME_SUBHEADER_SELECTBOX': 'asdasd',
        'DASHBOARD' : 'asdasd',
        'COURSES'   : 'asdasd',
        'INBOX' : 'asdasd',
        'CALENDAR' : 'asdasdsad',
        'ABOUT' : 'asdsdas',
        'SEMESTER' : 'asdsad',
        'LEARNING_MATERIAL' : 'asdasd',
        'SHARED_DOCUMENTS' : 'asdasd',
        'ASSIGN' : 'asdasd',
        'DISCUSSION' : 'asdasd',
        'EMAILS' : 'asdasd',
        'ANNOUNCEMENTS' : 'asdasd',
        'NOTHING' : 'asdsdas',
        'NO_RECENT' : 'asdasdsad'    
    });
 
    //Setting EN by default
    $translateProvider.preferredLanguage('en');



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

app.filter('index', function () {
    return function (array, index) {
        if (!index)
            index = 'index';
        for (var i = 0; i < array.length; ++i) {
            array[i][index] = i;
        }
        return array;
    };
});

app.directive('fileModel', ['$parse', 'fileService', function ($parse, fileService) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs, rootScope) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

console.log("in directive");

            element.bind('change', function(){
                modelSetter(scope, element[0].files[0]);
                    console.log("binding file");
                    //fileService.push(element[0].files[0]);
                    fileService.setUploadedFile(element[0].files[0]);
            });
        }
    };
}]);

app.service('fileUpload', ['$http', function ($http) {

console.log("service called");

    this.uploadFileToUrl = function(file, req, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(){
        })
        .error(function(){
        });
    }
}]);

app.factory('fileService', function() {
    // var files = [];
    // return files;

console.log("factory called");

    var uploadedFile;
    return{
        setUploadedFile : function(file){
            uploadedFile = file;
        },

        getUploadedFile : function(){
            return uploadedFile;
        },

        resetUploadedFile : function(){
            uploadedFile = null;
        }
    }
});



app.directive("ngFileSelect",function(){

  return {
    link: function($scope,el){

      el.bind("change", function(e){

        $scope.file = (e.srcElement || e.target).files[0];
        $scope.getFile();
      })

    }

  }
});