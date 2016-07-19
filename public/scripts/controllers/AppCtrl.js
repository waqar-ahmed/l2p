app.controller('AppCtrl', function($scope, $mdBottomSheet, $mdSidenav, $mdDialog, $location, courseService, $translate){
  $scope.toggleSidenav = function(menuId) {
    $mdSidenav(menuId).toggle();
  };

  $scope.navbartitle = "L2P - Home";
  var LOGIN_PAGE = "login.html";
  var en = true;



 	$scope.menu = [
      {
      link : '',
      title: ''+$translate.instant('DASHBOARD'),
      icon: 'dashboard'
    },
    {
      link : 'mycourses',
      title: ''+$translate.instant('COURSES'),
      icon: 'import_contacts'
    },
    {
      link : 'emails',
      title: ''+$translate.instant('INBOX'),
      icon: 'email'
    },
    {
      link : 'schedule',
      title: ''+$translate.instant('CALENDAR'),
      icon: 'date_range'
    },
	{
      link : 'about',
      title: ''+$translate.instant('ABOUT'),
      icon: 'copyright'
    }
  ];

  /*
  $scope.admin = [
    {
      link : 'settings',
      title: 'Settings',
      icon: 'settings'
    },
  {
      link : 'about',
      title: 'About',
      icon: 'copyright'
    },
  {
      link : 'contact',
      title: 'Contact',
      icon: 'send'
    }
  ];
  */
  $scope.authcourse = false;
  $scope.alert = '';



  //Locatlization

  $scope.updateLanguage = function(language) {
    $translate.use(language);

    if(language == 'en')
      en = true;
     else
      en = false;

     $scope.menu = [
      {
      link : '',
      title: ''+$translate.instant('DASHBOARD'),
      icon: 'dashboard'
    },
    {
      link : 'mycourses',
      title: ''+$translate.instant('COURSES'),
      icon: 'import_contacts'
    },
    {
      link : 'emails',
      title: ''+$translate.instant('INBOX'),
      icon: 'email'
    },
    {
      link : 'schedule',
      title: ''+$translate.instant('CALENDAR'),
      icon: 'date_range'
    },
 {
      link : 'about',
      title: ''+$translate.instant('ABOUT'),
      icon: 'copyright'
    }
  ];

    //Use this for binded values to update content for language
    if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
        $scope.$apply();
       }

  };

  //Localization Ends here



  // $scope.showListBottomSheet = function($event) {
  //   $scope.alert = '';
  //   $mdBottomSheet.show({
  //     template: '<md-bottom-sheet class="md-list md-has-header"> <md-subheader>Settings</md-subheader> <md-list> <md-item ng-repeat="item in items"><md-item-content md-ink-ripple flex class="inset"> <a flex aria-label="{{item.name}}" ng-click="listItemClick($index)"> <span class="md-inline-list-icon-label">{{ item.name }}</span> </a></md-item-content> </md-item> </md-list></md-bottom-sheet>',
  //     controller: 'ListBottomSheetCtrl',
  //     targetEvent: $event
  //   }).then(function(clickedItem) {
  //     $scope.alert = clickedItem.name + ' clicked!';
  //   });
  // };

  // set the navbartitle
  $scope.setNav = function(navTitle) {
      $scope.navbartitle = navTitle;
  }

  $scope.resetAuth = function()  {
    $scope.authcourse = false;
  }

  $scope.switchCourse = function(cid) {
    $location.path('singlecourse/'+cid);
  }

  $scope.onMenuSelect = function(link,title){
    console.log("on menu select " + link);
    $scope.navbartitle = "L2P - " + $translate.instant(title);
    $location.path("/" + link);
    $mdSidenav("left").close();
    $scope.resetAuth();
  };

  $scope.logout = function(){
      console.log("logout");
      courseService.logout();
      window.location = LOGIN_PAGE;
  }

});



