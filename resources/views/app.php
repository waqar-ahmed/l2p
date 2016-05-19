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
  	<!-- Angular Material Library -->
  	<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
  	<!-- // <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-route.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.0/angular-ui-router.js"></script>
  	<!-- My Application script files  -->
  	<script type="text/javascript" src="scripts/app.js"></script>
  	<script src="scripts/controllers/AppCtrl.js"></script>
  	<!-- // <script type="text/javascript" src="scripts/controllers/mainCtrl.js"></script> -->
  	<script src="scripts/controllers/homeCtrl.js"></script>
  	<script src="scripts/controllers/testCtrl.js"></script>

  	<!-- My Application stylesheets -->
</head>
<body ng-app="BlankApp" ng-cloak>
 <div layout="row" ng-controller="AppCtrl">
    <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')">
      <md-toolbar class="md-tall md-hue-2">
        <span flex></span>
        <div layout="column" class="md-toolbar-tools-bottom inset">
          <user-avatar></user-avatar>
          <span></span>
          <div>Firstname Lastname</div>
          <div>email@domainname.com</div>
        </div>
      </md-toolbar>
      <md-list>
      <md-item ng-repeat="item in menu">
        <a>
          <md-item-content md-ink-ripple layout="row" layout-align="start center">
            <div class="inset">
              <ng-md-icon icon="{{item.icon}}"></ng-md-icon>
            </div>
            <div class="inset" ng-click="onMenuSelect(item.link)">{{item.title}}
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
            <div class="inset">{{item.title}}
            </div>
          </md-item-content>
        </a>
      </md-item>
    </md-list>
    </md-sidenav>
    <div layout="column" class="relative" layout-fill role="main">
      <md-button class="md-fab md-fab-bottom-right" aria-label="Add" ng-click="showAdd($event)">
        <ng-md-icon icon="add"></ng-md-icon>
      </md-button>
      <md-toolbar ng-show="!showSearch">
        <div class="md-toolbar-tools">
          <md-button ng-click="toggleSidenav('left')" hide-gt-md aria-label="Menu">
            <ng-md-icon icon="menu"></ng-md-icon>
          </md-button>
          <h3>
            Dashboard
          </h3>
          <span flex></span>
          <md-button aria-label="Search" ng-click="showSearch = !showSearch">
            <ng-md-icon icon="search"></ng-md-icon>
          </md-button>
          <md-button aria-label="Open Settings" ng-click="showListBottomSheet($event)">
            <ng-md-icon icon="more_vert"></ng-md-icon>
          </md-button>
        </div>
        <md-tabs md-stretch-tabs class="md-primary" md-selected="data.selectedIndex">
          <md-tab id="tab1" aria-controls="tab1-content">
            Latest
          </md-tab>
          <md-tab id="tab2" aria-controls="tab2-content">
            Favorites
          </md-tab>
        </md-tabs>
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
        <ui-view layout="column" layout-fill layout-padding>
        
        </ui-view>
      </md-content>
    </div>
 </div>
  </body>
</html>

<!--
Copyright 2016 Google Inc. All Rights Reserved. 
Use of this source code is governed by an MIT-style license that can be in foundin the LICENSE file at http://material.angularjs.org/license.
-->