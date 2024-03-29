
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
        'HOME_SUBHEADER': 'Update',
        'HOME_SUBHEADER_SELECTBOX': 'Letzte',
        'DASHBOARD' : 'Dashboard',
        'COURSES'   : 'Veranstaltungen',
        'INBOX' : 'Posteingang',
        'CALENDAR' : 'Kalender',
        'ABOUT' : 'Über',
        'SEMESTER' : 'Semester',
        'LEARNING_MATERIAL' : 'Lernmaterial',
        'SHARED_DOCUMENTS' : 'Gemeinsame Dokumente',
        'ASSIGN' : 'Aufgaben',
        'DISCUSSION' : 'Diskussionsforum',
        'EMAILS' : 'E-Mails',
        'ANNOUNCEMENTS' : 'Ankündigung',
        'NOTHING' : 'Nichts zu zeigen',
        'NO_RECENT' : 'Keine neuen zu zeigen'    
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


app.filter('index', function () {    // index --> index
    return function (array, index) {
        if (!index)
            index = 'index';  // index --> index
        for (var i = 0; i < array.length; ++i) {
            array[i][index] = i;
        }
        return array;
    };
});

app.directive('fileModel', ['$parse', 'fileService', function ($parse, fileService) { // fileModel --> dateiModell    fileService --> dateiService
    return {
        restrict: 'A',  // A--> A
        link: function(scope, element, attrs, rootScope) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

console.log("in directive");  // in directive --> in Direktive

            element.bind('change', function(){  // change --> veraenderen
                modelSetter(scope, element[0].files[0]);
                    console.log("binding file"); // binding file --> Datei einbinden
                    //fileService.push(element[0].files[0]);
                    fileService.setUploadedFile(element[0].files[0]);
            });
        }
    };
}]);

app.service('fileUpload', ['$http', function ($http) { // fileupload --> Datei hochladen

console.log("service called");  // service called --> service angerufen

    this.uploadFileToUrl = function(file, req, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);  // file --> Datei
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

app.factory('fileService', function() {  // fileservice --> Datei Service
    // var files = [];
    // return files;

console.log("factory called"); // Fabrik angerufen

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



app.directive("ngFileSelect",function(){   // ngDateiWaehlen

  return {
    link: function($scope,el){

      el.bind("change", function(e){  // change --> veraenderen

        $scope.file = (e.srcElement || e.target).files[0];
        $scope.getFile();
      })

    }

  }
});