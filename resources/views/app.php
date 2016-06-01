<html lang="en" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<!-- Angular Material style sheet -->
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">

	<!-- Angular Material requires Angular.js Libraries -->
  	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
  	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
  	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/angular-material-icons/0.7.0/angular-material-icons.min.js"></script>

  	<!-- Angular Material Library -->
	<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>

  	<!-- Angular Routing Library -->
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.0/angular-ui-router.js"></script>

  	<!-- My Application script files  -->
  	<script src="scripts/app.js"></script>
  	<script src="scripts/controllers/AppCtrl.js"></script>
  	<script src="scripts/controllers/homeCtrl.js"></script>
  	<script src="scripts/controllers/testCtrl.js"></script>
    <script src="scripts/controllers/coursesCtrl.js"></script>
    <script src="scripts/controllers/singlecourseCtrl.js"></script>

    <!-- My Application module files  -->
    <script src="scripts/modules/treeView.js"></script>


  	<!-- My Application stylesheets -->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
  	<link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/treeView.css">
    <link rel="stylesheet" href="styles/course.css">
    <link rel="stylesheet" href="styles/singlecourse.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" />
    <!--[if IE 7]>
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" />
    <![endif]-->

</head>
<body ng-app="L2pLabApp" ng-cloak>
 <div layout="row" ng-controller="AppCtrl">
    <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')">
      <md-toolbar class="md-tall md-hue-2">
        <span flex></span>
        <div layout="column" class="md-toolbar-tools-bottom inset" layout-align="center center">
          <div class="homeimage">
            <img src="images/favicon.ico"></img>
          </div>
          <span flex></span>
<!--           <div class="inset" ng-show="!loggedin">
            <a class="inset md-hue-1" ng-href="https://oauth.campus.rwth-aachen.de/manage" target="_blank">Click me to authorize</a>
          </div> -->
          <div layout="row" layout-align="start center">
            <div class="inset" flex-offset="20" flex="60">Donald Trump</div>
            <div flex>
              <md-button ng-click="logout()">
                <ng-md-icon icon="logout"></ng-md-icon>
              </md-button>
            </div>
          </div>
        </div>
      </md-toolbar>
      <md-list>
      <md-item ng-repeat="item in menu">
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
      <md-divider></md-divider>
      <md-subheader>Management</md-subheader>
      <md-item ng-repeat="item in admin">
        <a>
          <md-item-content md-ink-ripple layout="row" layout-align="start center">
            <div class="inset">
              <ng-md-icon icon="{{item.icon}}"></ng-md-icon>
            </div>
            <div class="inset"ng-click="onMenuSelect(item.link)">{{item.title}}
            </div>
          </md-item-content>
        </a>
      </md-item>
    </md-list>
    </md-sidenav>
    <div layout="column" class="relative" layout-fill role="main">
<!--       <md-button class="md-fab md-fab-bottom-right" aria-label="Add" ng-click="showAdd($event)">
        <ng-md-icon icon="add"></ng-md-icon>
      </md-button> -->
      <md-toolbar ng-show="!showSearch">
        <div class="md-toolbar-tools">
          <md-button ng-click="toggleSidenav('left')" hide-gt-md aria-label="Menu">
            <ng-md-icon icon="menu"></ng-md-icon>
          </md-button>
          <h3>
            {{navbartitle}}
          </h3>
          <span flex></span>

          <md-button aria-label="Open Settings" ng-click="showListBottomSheet($event)">
            <ng-md-icon icon="more_vert"></ng-md-icon>
          </md-button>
        </div>
       <!--  <md-tabs md-stretch-tabs class="md-primary" md-selected="data.selectedIndex">
          <md-tab id="tab1" aria-controls="tab1-content">
            Latest
          </md-tab>
          <md-tab id="tab2" aria-controls="tab2-content">
            Favorites
          </md-tab>
        </md-tabs> -->
      </md-toolbar>
      <md-toolbar class="md-hue-1" ng-show="showSearch">
        <div class="md-toolbar-tools">
          <md-button ng-click="showSearch = !showSearch" aria-label="Back">
            <ng-md-icon icon="arrow_back"></ng-md-icon>
          </md-button>
          <h3 flex="10">
            Back
          </h3>
          <md-input-container md-theme="input" flex>
            <label>&nbsp;</label>
            <input ng-model="search.who" placeholder="enter search">
          </md-input-container>
          <md-button aria-label="Search" ng-click="showSearch = !showSearch">
            <ng-md-icon icon="search"></ng-md-icon>
          </md-button>
          <md-button aria-label="Open Settings" ng-click="showListBottomSheet($event)">
            <ng-md-icon icon="more_vert"></ng-md-icon>
          </md-button>
        </div>

      </md-toolbar>
      <md-content flex md-scroll-y>

      	<!-- This is a place where your content will be loaded -->
        <ui-view layout="column" layout-fill layout-padding>
        </ui-view>

      </md-content>
    </div>
 </div>
  </body>
</html>
