app.controller('AppCtrl', function($scope, $mdBottomSheet, $mdSidenav, $mdDialog, $location, courseService){
  $scope.toggleSidenav = function(menuId) {
    $mdSidenav(menuId).toggle();
  };

  $scope.navbartitle = "L2P - Home";
  var LOGIN_PAGE = "login.html";

 	$scope.menu = [
      {
      link : '',
      title: 'Dashboard',
      icon: 'dashboard'
    },
    {
      link : 'mycourses',
      title: 'Courses',
      icon: 'import_contacts'
    },
    {
      link : 'emails',
      title: 'Inbox',
      icon: 'email'
    },
    {
      link : 'schedule',
      title: 'Calendar',
      icon: 'date_range'
    },
	{
      link : 'about',
      title: 'About',
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

  $scope.showListBottomSheet = function($event) {
    $scope.alert = '';
    $mdBottomSheet.show({
      template: '<md-bottom-sheet class="md-list md-has-header"> <md-subheader>Settings</md-subheader> <md-list> <md-item ng-repeat="item in items"><md-item-content md-ink-ripple flex class="inset"> <a flex aria-label="{{item.name}}" ng-click="listItemClick($index)"> <span class="md-inline-list-icon-label">{{ item.name }}</span> </a></md-item-content> </md-item> </md-list></md-bottom-sheet>',
      controller: 'ListBottomSheetCtrl',
      targetEvent: $event
    }).then(function(clickedItem) {
      $scope.alert = clickedItem.name + ' clicked!';
    });
  };

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
    console.log("on menu select" + link);
    $scope.navbartitle = "L2P - " + title;
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

app.directive("contenteditable", function() {
  return {
    restrict: "A",
    require: "ngModel",
    link: function(scope, element, attrs, ngModel) {

      function read() {
        ngModel.$setViewValue(element.html());
      }

      ngModel.$render = function() {
        element.html(ngModel.$viewValue || "");
      };

      element.bind("blur keyup change", function() {
        scope.$apply(read);
      });
    }
  };
});

