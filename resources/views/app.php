<html lang="en" >
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Link for fullCalendar CSS  -->
		<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.css"/>

        <!-- Angular Material requires Angular.js Libraries -->
	    <script src="bower_components/angular/angular.min.js"></script>
        <script src="bower_components/angular-animate/angular-animate.min.js"></script>
        <script src="bower_components/angular-aria/angular-aria.min.js"></script>
        <script src="bower_components/angular-material/angular-material.min.js"></script>
        <script src="bower_components/angular-material-icons/angular-material-icons.min.js"></script>

        <link rel="stylesheet" href="bower_components/angular-material/angular-material.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-sanitize.min.js"></script>

        <!-- Jquery Library -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Tree control javascript -->
        <script type="text/javascript" src="bower_components/angular-tree-control/angular-tree-control.js"></script>

        <!-- link for CSS when using the tree as a Dom element -->
        <link rel="stylesheet" type="text/css" href="bower_components/angular-tree-control/css/tree-control.css">

        <!-- link for CSS when using the tree as an attribute -->
        <link rel="stylesheet" type="text/css" href="bower_components/angular-tree-control/css/tree-control-attribute.css">

        <!-- Angular Routing Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.0/angular-ui-router.js"></script>

        <!-- jquery, moment, and angular have to get included before fullcalendar -->
        <!--script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script-->
        <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
        <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.js"></script>
        <script type="text/javascript" src="bower_components/angular-ui-calendar/src/calendar.js"></script>
        <script type="text/javascript" src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script type="text/javascript" src="bower_components/text_truncate/ng-text-truncate.js"></script>



        <script src="bower_components/ng-file-upload/ng-file-upload.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-tree/2.16.0/angular-ui-tree.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-tree/2.16.0/angular-ui-tree.js"></script>

        <!-- // <script src="bower_components/flat-to-nested-js/index.js"></script> -->
        <script src="scripts/modules/flat-nested.js"></script>


        <!-- My Application script files  -->
        <script src="scripts/app.js"></script>
        <script src="scripts/controllers/AppCtrl.js"></script>
        <script src="scripts/controllers/homeCtrl.js"></script>
        <script src="scripts/controllers/testCtrl.js"></script>
        <script src="scripts/controllers/coursesCtrl.js"></script>
        <script src="scripts/controllers/singlecourseCtrl.js"></script>
        <script src="scripts/controllers/scheduleCtrl.js"></script>
        <script src="scripts/controllers/emailsCtrl.js"></script>
        <script src="scripts/controllers/DialogController.js"></script>
        <script src="scripts/controllers/aboutCtrl.js"></script>
        <script src="scripts/controllers/DiscussionDialogController.js"></script>
        <script src="scripts/controllers/EmailDialogController.js"></script>
        <script src="scripts/controllers/AnnounDialogController.js"></script>
        <script src="scripts/modules/upload.js"></script>

        <!-- My Application module files  -->
        <!-- // <script src="scripts/modules/treeView.js"></script> -->


        <!-- My Application stylesheets -->
        <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/viewEmail.css">

        <link rel="stylesheet" href="styles/calendar.css">

        <link rel="stylesheet" href="styles/treeView.css">
        <link rel="stylesheet" href="styles/course.css">
         <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/emails.css">
        <link rel="stylesheet" href="styles/singlecourse.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
                <!--[if IE 7]>
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- My Application services -->
        <script src="scripts/services/courseService.js"></script>
         <script src="scripts/services/colorService.js"></script>

    </head>
    <body ng-app="L2pLabApp" ng-cloak>
        <div layout="row" ng-controller="AppCtrl">
            <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')">
                <md-toolbar class="md-tall md-hue-2">
                    <span flex></span>
                    <div layout="column" class="md-toolbar-tools-bottom inset" layout-align="center center">
                        <div class="homeimage">
                            <img src="images/icon.jpg"></img>
                        </div>
                        <span flex></span>
                        <!--           <div class="inset" ng-show="!loggedin">
                                    <a class="inset md-hue-1" ng-href="https://oauth.campus.rwth-aachen.de/manage" target="_blank">Click me to authorize</a>
                                  </div> -->
                        <div layout="row" layout-align="start center">
                            <div class="inset" flex-offset="20" flex="65">Welcome</div>
                            <div flex="10">
                                <md-button ng-click="logout()" class="md-icon-button">
                                    <ng-md-icon icon="logout"></ng-md-icon>
                                </md-button>
                            </div>
                        </div>
                    </div>
                </md-toolbar>

                <md-list>
					<md-item ng-repeat="item in menu">
						<md-divider ng-if="$last"></md-divider>
                        <a>
							<md-item-content md-ink-ripple layout="row" layout-align="start center">

                                <div class="inset">
                                    <ng-md-icon icon="{{item.icon}}"></ng-md-icon>
                                </div>
                                <div class="inset" ng-click="onMenuSelect(item.link,item.title)">{{item.title}}
                                </div>
                            </md-item-content>
                        </a>
					</md-item>
                </md-list>
            </md-sidenav>

            <div layout="column" class="relative" layout-fill role="main">
                <md-toolbar>
                    <div class="md-toolbar-tools">
                        <md-button class="md-icon-button" ng-click="toggleSidenav('left')" hide-gt-md aria-label="Menu">
                            <ng-md-icon icon="menu"></ng-md-icon>
                        </md-button>
                        <h3 class="main_title"> {{navbartitle}}</h3>
                        <span flex></span>
                        <md-menu md-position-mode="target-right target">

                            <md-button class="md-icon-button" aria-label="Open Settings" ng-click="$mdOpenMenu($event)" ng-show="authcourse">
                                <ng-md-icon icon="more_vert"></ng-md-icon>
                            </md-button>

                              <md-menu-content>
                                <md-menu-item ng-repeat="singlecourse in courseinfo|filter: {'uniqueid':'!'+filterid}" class="custom_menu">
                                  <md-button ng-click="switchCourse(singlecourse.uniqueid)" class="course_selector">
                                  {{singlecourse.courseTitle}}
                                  </md-button>
                                </md-menu-item>
                              </md-menu-content>

                        </md-menu>
                    </div>
                </md-toolbar>

                <md-content flex md-scroll-y style="overflow-x:hidden; overflow-y:hidden;">
                    <!-- This is a place where your content will be loaded -->
                    <ui-view layout="column" layout-fill layout-padding>
                    </ui-view>

                </md-content>
            </div>
        </div>
    </body>
</html>
