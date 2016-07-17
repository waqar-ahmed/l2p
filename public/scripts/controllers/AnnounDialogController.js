function AnnounDialogController($scope, $mdDialog, courseService, selectedAnnouncement, method, cid, resetLoading, refreshAnnouns, $mdToast, refresh, showSimpleToast) {

	$scope.authWrite = true;
	$scope.authEdit = true;
	$scope.authShow = false;

	$scope.announce_heading = '';
	$scope.isEdit = false;
	$scope.announce_button = '';

	if (method == 'creat'){
		$scope.authWrite = true;
		$scope.announce_heading = 'New Announcement';
		$scope.expireEdited = new Date();
		isEdit = false;
		$scope.announce_button = 'Add';
	}
	else if (method == 'read'){
		$scope.authShow = true;
		$scope.currentannoun = selectedAnnouncement;
		if ($scope.currentannoun.expireTime != 0) {
			var tempDate = new Date();
			// parse the time variable to the js version
			tempDate.setTime($scope.currentannoun.expireTime*1000);
			$scope.expireEdited = tempDate;
		}
	}
	else if (method == 'edit'){
		$scope.authEdit = true;
		$scope.announce_heading = 'Edit Announcement';
		$scope.announce_button = 'Edit';
		$scope.authShow = true;
		$scope.isEdit = true;
		$scope.currentannoun = selectedAnnouncement;
		$scope.currentannoun.body = parseString($scope.currentannoun.body);
		if ($scope.currentannoun.expireTime != 0) {
			// parse the time variable to the js version
			var tempDate = new Date();
			tempDate.setTime($scope.currentannoun.expireTime*1000);
			$scope.expireEdited = tempDate;
		}
	}
	// var template = angular.element($scope.currentannoun.body);
	// $scope.currentannoun.bodyEdited = $compile(template);

	// delete the html tags from the body
	function parseString(str) {
		if (str != null) {
			str = str.replace(/<br>/gi, "\n");
			str = str.replace(/<p.*>/gi, "\n");
			str = str.replace(/<a.*href="(.*?)".*>(.*?)<\/a>/gi, " $2 (Link->$1) ");
			str = str.replace(/<(?:.|\s)*?>/g, "");
		}
		return str;
	}

  	$scope.back = function() {
  		$scope.editannouncement = false;
  		console.log("On Cancel Edit Announcement: "+ $scope.editannouncement);
    	$mdDialog.hide();
  	};

  	// $scope.activeEdit = function() {
   //  	$scope.authWrite = true;
   //  	$scope.authEdit = false;
  	// };

  	$scope.addAnnoun = function(){
  		console.log($scope.expireEdited.toString());
  		// parse the time variable to the l2p version
  		var expireTime = Math.ceil($scope.expireEdited.getTime()/1000)+7200;
  		console.log(expireTime);
  		var newAnnouncement = {
			"title": $scope.currentannoun.title,
			"body": $scope.currentannoun.body,
			"expireTime": expireTime,
  		};

  		console.log(newAnnouncement);
  		courseService.addAnnoun(cid, newAnnouncement)
		.then(function(res){
			console.log("new announcement sent");
			console.log(res);
			$scope.back();
			resetLoading();
			refreshAnnouns();
			refresh();
			showSimpleToast("New Announcement has been added");
		},
		function(err){
			console.log("Error occured : " + err);
		});
  	}

		$scope.editAnnoun = function(){
  		if ($scope.expireEdited != undefined){
  			if ($scope.expireEdited != tempDate){
	  			var expireTime = Math.ceil($scope.expireEdited.getTime()/1000)+7200;
	  		}
	  		else {
	  			var expireTime = Math.ceil($scope.expireEdited.getTime()/1000);
	  		}
	  	}
	  	else {
	  		var expireTime = 0;
	  	}
  		console.log(expireTime);
  		var editedAnnouncement = {
			"title": $scope.currentannoun.title,
			"body": $scope.currentannoun.body,
			"expireTime": expireTime,
  		};

  		console.log(editedAnnouncement);
  		courseService.editAnnoun(cid, editedAnnouncement,$scope.currentannoun.itemId)
		.then(function(res){
			console.log("announcement is updated");
			console.log(res);
			$scope.back();
			resetLoading();
			refreshAnnouns();
			refresh();
			//$window.alert("annuncement is updated");
			showSimpleToast("Announcement has been updated");

		},
		function(err){
			console.log("Error occured : " + err);
		});
  	}
};