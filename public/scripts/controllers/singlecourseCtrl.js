
app.controller('singlecourseCtrl', function($rootScope, $scope, $stateParams, $filter, courseService, $mdDialog, $window, colorService, $mdToast, $timeout, fileReader) {

	var LOGIN_PAGE = "login.html";
	var sem = $stateParams.cid.substring(2,4)+$stateParams.cid.substring(0,2);
	var orginalDiscussions = [];
	var countDisucussions = 0;
	var transferArray = [];

	$scope.discussLoaded = false;
	$scope.emailsLoaded = false;
	$scope.announcementsLoaded = false;
	$scope.$parent.authcourse = true;
	$scope.WaitForToast = true;
	$scope.breadcrums = [''];
	$scope.discussions = [];

	$scope.firstLetter = "";
    $scope.colors_email = [];
    $scope.colors_announcement = [];


	$scope.show_replies = false;

	//Checking if user is authenticated or not
	/*
	courseService.isUserAuthenticated()
	.then(function(res){
		if(res.Status == true)
		{
			console.log("user is authenticated");
		}
		else{
			gotoAuthorizePage();
		}
	}, function(err){
		console.log("Error occured : " + err);
	});


	gotoAuthorizePage = function(){
		window.location = LOGIN_PAGE;
	}
	*/

	/* recover from error : log out */
	function errorRecover(){
		$scope.showSimpleToast("Time out, please login again");
		courseService.logout();
		window.location = LOGIN_PAGE;
	}

	$scope.onTabChanges = function($index){
		console.log("Tab index : " + $index);
	}

	console.log("course ID: " + $stateParams.cid);

	/* get all Discussions */
	courseService.getAllDiscussions($stateParams.cid)
		.then(function(res){
			if(res.Status === undefined || res.Status == false){
				errorRecover();
			}
			else if(res.dataSet === undefined || res.dataSet.length == 0){
				console.log("no discussions");
				console.log(res);
				orginalDiscussions = undefined;
			}else{
				console.log("got discussions");
				console.log(res.dataSet);
				orginalDiscussions = res.dataSet;
				$scope.parseDiscuss();
			}
			$scope.discussLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
	});
	/* get Emails by cid*/
	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			if(res.dataSet === undefined || res.dataSet.length == 0){
				console.log("no emails");
				$scope.emails = undefined;
			}else{
				console.log("got emails");
				console.log(res.dataSet);
				$scope.emails = res.dataSet;
				$scope.colors_email = colorService.generateColors($scope.emails.length);
			}
			$scope.emailsLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
	});
	/* get Announcements by cid*/
	courseService.getAnnounbyid($stateParams.cid)
		.then(function(res){
			if(res.dataSet === undefined || res.dataSet.length == 0){
				console.log("no announcements");
				$scope.announcements = undefined;
			}else{
				console.log("got announcements");
				console.log(res.dataSet);
				$scope.announcements = res.dataSet;
				$scope.colors_announcement = colorService.generateColors($scope.announcements.length);
			}
			$scope.announcementsLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
	});
	/* get User Role by cid*/
	 courseService.viewUserRole($stateParams.cid)
		.then(function(res){
			console.log("got role");
			console.log(res);
			$scope.userRole = res.role.toString();
			$scope.setRole();
		}, function(err){
			console.log("Error occured : " + err);
	});
	/* get Courses by sem*/
	courseService.getCurrentSem(sem)
		.then(function(res){
			console.log("got course by currentsemester");
			console.log(res.dataSet);
			$scope.$parent.courseinfo = res.dataSet;
			var currentCourse = $.grep($scope.$parent.courseinfo, function(n,i) {
  				return n.uniqueid === $stateParams.cid;
			});
			$scope.$parent.filterid = currentCourse[0].uniqueid;
			console.log($scope.$parent.filterid);
			$scope.$parent.setNav(currentCourse[0].courseTitle);
		}, function(err){
			console.log("Error occured : " + err);
	});

	/* get Learning Materials by cid*/
	courseService.getAllLearningMaterials($stateParams.cid)
	.then(function(res){
		if(res.dataSet === undefined || res.dataSet.length == 0){
			console.log("no Learning Materials");
			$scope.roleList = undefined;
		}else{
			console.log("get all learningMaterials ");
			console.log(res.dataSet);
			$scope.roleList = parseLearningMaterials(res.dataSet);
		}
		$scope.dataLoaded = true;
		//console.log(buildHierarchy(items));
	}, function(){
		console.log("Error occured");
	});


	loadAllSharedDocs();


	/* get Assignments by cid*/
	courseService.getAllAssignments($stateParams.cid)
	.then(function(res){
		if(res.dataSet === undefined || res.dataSet.length == 0){
			console.log("no assignments");
			$scope.assignments = undefined;
		}else{
			console.log("get all assignments ");
			console.log(res.dataSet);
			$scope.assignments = res.dataSet;
			console.log("Assingment length: "+ $scope.assignments.length);
		}
		$scope.dataLoaded = true;
	}, function(){
		console.log("Error occured");
	});

	function loadAllSharedDocs(){
		/* get Shared Docs by cid*/
	courseService.getAllSharedDocs($stateParams.cid)
	.then(function(res){
		if(res.dataSet === undefined ||res.dataSet.length == 0){
			console.log("no Share Docs")
			$scope.allSharedDocs = undefined;
		}
		else{
			console.log("get all shared Docs");
			console.log(res.dataSet);
			$scope.allSharedDocs = parseLearningMaterials(res.dataSet);
		}
		$scope.dataLoaded = true;
		//console.log(buildHierarchy(items));
	}, function(){
		console.log("Error occured");
	});
	}

	var iconClassMap = {
		txt: 'icon-file-text',
		jpg: 'icon-picture blue',
		png: 'icon-picture orange',
		gif: 'icon-picture'
	},
		defaultIconClass = 'icon-file';

	$scope.options3 = {
		mapIcon: function (file) {
			var pattern = /\.(\w+)$/,
				match = pattern.exec(file.name),
				ext = match && match[1];

			return iconClassMap[ext] || defaultIconClass;
		}
	};


	// /* Display dynamic Course Info by cid*/
	// courseService.getCourseInfo($stateParams.cid)
	// 	.then(function(res){
	// 		console.log("got CourseInfo");
	// 		console.log(res.dataSet);
	// 		$scope.courseinfos = [
	// 			{
	// 				coursetitle: String(res.dataSet[0].courseTitle),
	// 				description: String(res.dataSet[0].description),
	// 				url: String(res.dataSet[0].url),

	// 			},
	// 		];
	// 	}, function(err){
	// 		console.log("Error occured : " + err);
	// });

	$scope.showSimpleToast= function(message) {
	    $mdToast.show(
	      $mdToast.simple()
	        .textContent(message)
	        .position('bottom')
	        .hideDelay(1200)
	    );
 	}

	$scope.trimFirstLetter = function(sentFrom){
    	return String(sentFrom).charAt(0);
  	};

	$scope.setRole = function(){
		if ($scope.userRole.indexOf("manager")!==-1){
			$scope.authCUD = true;}
		else if ($scope.userRole.indexOf("student")!==-1){
			$scope.authCUD = false;}
		console.log($scope.authCUD);
	}

	$scope.test = function() {
		console.log("test");
	}

	$scope.parseDiscuss = function() {
		var index = 0;
		for (var i=countDisucussions; i<orginalDiscussions.length; i++){
			if (orginalDiscussions[i].selfId == orginalDiscussions[i].parentDiscussionId) {
				var tempArray = {
					"selfId": orginalDiscussions[i].selfId,
					"value": index,
				};
				index++;
				transferArray.push(tempArray);
				orginalDiscussions[i].counts = 0;
				$scope.discussions.push(orginalDiscussions[i]);
			}
			else {
				var master = $filter('filter')(transferArray,{'selfId':orginalDiscussions[i].parentDiscussionId})[0].value;
				if ($scope.discussions[master].children == undefined) {
					$scope.discussions[master].children = [];
				}
				if (orginalDiscussions[i].replyToId!=orginalDiscussions[i].parentDiscussionId) {
					var fromData =  $filter('filter')($scope.discussions[master].children,{'selfId':orginalDiscussions[i].replyToId})[0];
					orginalDiscussions[i].fromName = fromData.from;
					orginalDiscussions[i].fromLevel = fromData.level;
				}
				var level = $scope.discussions[master].children.length+1;
				orginalDiscussions[i].level = level;
				$scope.discussions[master].children.push(orginalDiscussions[i]);
				$scope.discussions[master].counts = $scope.discussions[master].children.length;
			}
		}
		countDisucussions = orginalDiscussions.length;
		console.log("data is parsed");
		console.log($scope.discussions);
	}

	$scope.addDiscussion = function(){
		// if (discussion === undefined)
		// 	{selectedDiscussion = {};}
		// else
		// 	{selectedDiscussion = discussion;}
	    $mdDialog.show({
	    	controller: DiscussionDialogController,
	    	locals: {
	    		// selectedDiscussion: angular.copy(selectedDiscussion),
	    		// method: method,
	    		cid: $stateParams.cid,
	    		resetLoading: $scope.resetDiscussLoading.bind(self),
	    		refreshDiscussions: $scope.refreshDiscussions.bind(self),
	    		refresh: $scope.refresh.bind(self),
	    		showSimpleToast: $scope.showSimpleToast.bind(self),
	    	},
	    	bindToController: true,
	      	templateUrl:'templates/viewdiscussion.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:false
	    });
	};

	$scope.addDiscussionReply = function(replyToId, body) {
		var discussion = {
			"subject": "Reply",
			"body": body,
		};
		console.log(replyToId);
		console.log(discussion);
		courseService.addDiscussionReply($stateParams.cid, replyToId, discussion)
			.then(function(res){
				console.log("new discussion reply added");
				console.log(res);
				$scope.resetDiscussLoading();
				$scope.refreshDiscussions();
				$scope.refresh();
				$scope.showSimpleToast("Discussion Reply has been added!");
			}, function(err){
				console.log("Error occured : " + err);
		});
	}

/* delete Discussion */
	$scope.showConfirmDiscussion = function(ev,selfId,outerindex) {
    // Appending dialog to document.body to cover sidenav in docs app
    var confirm = $mdDialog.confirm()
          .title('Would you like to delete discussion?')
          .textContent('')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('Delete')
          .cancel('Cancel');
    	$mdDialog.show(confirm).then(function() {
		$scope.resetDiscussLoading();
    	$scope.discussions.splice(outerindex,1);
    	$scope.deleteDiscussion(selfId);
    	$scope.refresh();
    	$scope.showSimpleToast("Discussion has been deleted");
    	}, function() {
			console.log("confirmation canceled");
		});
  	};

  	$scope.deleteDiscussion = function(selfId) {
  		courseService.deleteDiscussion($stateParams.cid,selfId)
			.then(function(res){
				console.log("discussion deleted");
				console.log(res);
				$scope.refreshDiscussions();
			}, function(err){
				console.log("Error occured : " + err);
		});
  	}

  	$scope.showConfirmDiscussionReply = function(ev,selfId,outerindex,innerindex) {
    // Appending dialog to document.body to cover sidenav in docs app
    var confirm = $mdDialog.confirm()
          .title('Would you like to delete discussion Reply?')
          .textContent('')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('Delete')
          .cancel('Cancel');
    	$mdDialog.show(confirm).then(function() {
		$scope.resetDiscussLoading();
    	$scope.discussions[outerindex].children.splice(innerindex);
    	$scope.discussions[outerindex].counts--;
    	$scope.deleteDiscussion(selfId);
    	$scope.refresh();
    	$scope.showSimpleToast("Discussion Reply has been deleted");
    	}, function() {
			console.log("confirmation canceled");
		});
  	};

	/* refresh Discussions */
	$scope.refreshDiscussions = function(){
		courseService.getAllDiscussions($stateParams.cid)
			.then(function(res){
				console.log("refresh discussions");
				console.log(res.dataSet);
				orginalDiscussions = res.dataSet;
				$scope.parseDiscuss();
				$scope.discussLoaded = true;
			}, function(err){
				console.log("Error occured : " + err);
		});
	}

	$scope.resetDiscussLoading = function() {
		$scope.discussLoaded = false;
	}

	function DiscussionDialogController($scope, $mdDialog, courseService, cid, resetLoading, refreshDiscussions, refresh, showSimpleToast) {
	  	$scope.back = function() {
	    	$mdDialog.hide();
	  	};

	  	$scope.addDisucssion = function(){
	  		var newDiscussion = {
	  			"subject": $scope.discussion.subject,
	  			"body": $scope.discussion.body,
	  		};
	  		console.log(newDiscussion);
	  		courseService.addDiscussion(cid, newDiscussion)
			.then(function(res){
				console.log("new email added");
				console.log(res);
				$scope.back();
				resetLoading();
				refreshDiscussions();
				refresh();
				showSimpleToast("New Discussion has been added");
			},
			function(err){
				console.log("Error occured : " + err);
			});
	  	}
	};

	/* view Email details */
	$scope.viewEmail = function(email,method){
		if (email === undefined)
			{selectedEmail = {};}
		else
			{selectedEmail = email;}
	    $mdDialog.show({
	    	controller: EmailDialogController,
	    	locals: {
	    		selectedEmail: angular.copy(selectedEmail),
	    		method: method,
	    		cid: $stateParams.cid,
	    		resetLoading: $scope.resetEmailLoading.bind(self),
	    		refreshEmail: $scope.refreshEmails.bind(self),
	    		refresh: $scope.refresh.bind(self),
	    		showSimpleToast: $scope.showSimpleToast.bind(self),
	    	},
	    	bindToController: true,
	      	templateUrl:'templates/viewemail.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:false
	    });
	};

	$scope.showConfirmEmail = function(ev,email) {
    // Appending dialog to document.body to cover sidenav in docs app
    var confirm = $mdDialog.confirm()
          .title('Would you like to delete email?')
          .textContent('')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('Delete')
          .cancel('Cancel');
    	$mdDialog.show(confirm).then(function() {
    	$scope.deleteEmail(email);
    	$scope.refresh();
    	$scope.showSimpleToast("Email has been deleted");
    	}, function() {
			console.log("confirmation canceled");
		});
  	};

	/* delete Email */
	$scope.deleteEmail = function(email) {
  	courseService.deleteEmail($stateParams.cid, email.itemId)
		.then(function(res){
			console.log("email is deleted");
			console.log(res);
			//$window.alert("email is deleted");
			console.log("email is deleted");
			$scope.resetEmailLoading()
			$scope.refreshEmails();
		},
		function(err){
			console.log("Error occured : " + err);
		});
  	}

	/* refresh Emails */
	$scope.refreshEmails = function(){
	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			console.log("refresh emails");
			console.log(res.dataSet);
			$scope.emails = res.dataSet;
			$scope.colors_email = colorService.generateColors($scope.emails.length);
			$scope.emailsLoaded = true;
		},
		function(err){
			console.log("Error occured : " + err);
		});
	}

	$scope.resetEmailLoading = function() {
		$scope.emailsLoaded = false;
	}


	function EmailDialogController($scope, $mdDialog, courseService, selectedEmail, method, cid, resetLoading, refreshEmail, $mdToast, refresh, showSimpleToast) {
		$scope.authWrite = false;
		$scope.authDelete = false;
		$scope.authShow = false;
		$scope.recipients = ["extra","tutors","managers","students"];

		if (method == 'creat'){
			$scope.authWrite = true;
		}
		else if (method == 'read'){
			$scope.authShow = true;
			$scope.currentemail = selectedEmail;
		}

	  	$scope.back = function() {
	    	$mdDialog.hide();
	  	};

	  	editRecipient = function() {
	  		var strRecipient = "";
	  		for (var key in $scope.selectedRecipient) {
	  			strRecipient = strRecipient+ $scope.selectedRecipient[key]+ ";";
	  		}
	  		console.log("edited recipient is "+ strRecipient);
	  		return strRecipient;
	  	}

	  	$scope.addEmail = function(){
	  		$scope.currentemail.replyTo = "Reply to my address";
	  		$scope.currentemail.recipients = editRecipient();
	  		var newEmail = {
	  			"recipients": $scope.currentemail.recipients,
	  			"subject": $scope.currentemail.subject,
	  			"body": $scope.currentemail.body,
	  			"replyTo": $scope.currentemail.replyTo,
	  			"cc" : $scope.currentemail.cc,
	  		};

	  		console.log(newEmail);

	  		courseService.addEmail(cid, newEmail)
			.then(function(res){
				console.log("new email sent");
				console.log(res);
				$scope.back();
				resetLoading();
				refreshEmail();
				//$window.alert("new email is sent");
				refresh();
				showSimpleToast("Email has been sent");
			},
			function(err){
				console.log("Error occured : " + err);
			});
	  	}
	};


	/* Announcements details */
	$scope.viewAnnoun = function(announcement,method){
		if (announcement === undefined)
			{selectedAnnouncement = {};}
		else
			{selectedAnnouncement = announcement;}
	    $mdDialog.show({
	    	controller: AnnounDialogController,
	    	locals: {
	    		selectedAnnouncement: angular.copy(selectedAnnouncement),
	    		method: method,
	    		cid: $stateParams.cid,
	    		resetLoading: $scope.resetAnnounLoading.bind(self),
	    		refreshAnnouns: $scope.refreshAnnouns.bind(self),
	    		refresh: $scope.refresh.bind(self),
	    		showSimpleToast: $scope.showSimpleToast.bind(self),

	    	},
	    	bindToController: true,
	      	templateUrl:'templates/viewannouncement.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:false
	    });
	};

	$scope.showConfirmAnnoucnment = function(ev,ann) {
    // Appending dialog to document.body to cover sidenav in docs app
	    var confirm = $mdDialog.confirm()
	          .title('Would you like to delete Announcement?')
	          .textContent('')
	          .ariaLabel('Lucky day')
	          .targetEvent(ev)
	          .ok('Delete')
	          .cancel('Cancel');

	    $mdDialog.show(confirm).then(function() {
	    	$scope.deleteAnnoun(ann);
	    	$scope.refresh();
	    	$scope.showSimpleToast("Announcement has been deleted");
	    }, function() {
			console.log("confirmation canceled");
	    });
  	};

	/* delete Announcements */
	$scope.deleteAnnoun = function(announcement) {
		courseService.deleteAnnoun($stateParams.cid, announcement.itemId)
		.then(function(res){
			console.log("announcement is deleted");
			console.log(res);
			//$window.alert("announcement is deleted");
			$scope.resetAnnounLoading();
			$scope.refreshAnnouns();
		},
		function(err){
			console.log("Error occured : " + err);
		});
	}

	/* refresh Announcements */
	$scope.refreshAnnouns = function(){
	courseService.getAnnounbyid($stateParams.cid)
		.then(function(res){
			console.log("refresh announcements");
			console.log(res.dataSet);
			$scope.announcements = res.dataSet;
			$scope.colors_announcement = colorService.generateColors($scope.announcements.length);
			$scope.announcementsLoaded = true;
		},
		function(err){
			console.log("Error occured : " + err);
		});
	}

	$scope.resetAnnounLoading = function() {
		$scope.announcementsLoaded = false;
	}

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
				var tempDate = new Date();
				tempDate.setTime($scope.currentannoun.expireTime*1000);
				$scope.expireEdited = tempDate;
			}
		}
		// var template = angular.element($scope.currentannoun.body);
		// $scope.currentannoun.bodyEdited = $compile(template);

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

	  	$scope.activeEdit = function() {
	    	$scope.authWrite = true;
	    	$scope.authEdit = false;
	  	};

	  	$scope.addAnnoun = function(){
	  		console.log($scope.expireEdited.toString());
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
		  		var expireTime = Math.ceil($scope.expireEdited.getTime()/1000)+7200;
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

	$scope.refresh = function() {
		$scope.WaitForToast = false;
		$timeout(function(){
          $scope.WaitForToast = true;
       }, 2000);
	}

function convert(array){
    var map = {}
    for(var i = 0; i < array.length; i++){
        var obj = array[i]
        if(!(obj.id in map)){
            map[obj.id] = obj
            map[obj.id].nodes = []
        }

        if(typeof map[obj.id].name == 'undefined'){
            map[obj.id].id = obj.itemId
            map[obj.id].name = obj.name
            map[obj.id].parentId= obj.parentFolderId
        }

        var parent = obj.parentFolderId || '-';
        if(!(parent in map)){
            map[parent] = {}
            map[parent].nodes = []
        }

        map[parent].nodes.push(map[obj.id])
    }
    console.log(map);
    return map;
}




function parseLearningMaterials(y){

	flatToNested = new FlatToNested({
	    // The name of the property with the node id in the flat representation
	    id: 'itemId',
	    // The name of the property with the parent node id in the flat representation
	    parent: 'parentFolderId',
	    // The name of the property that will hold the children nodes in the nested representation
	    children: 'nodes'
	});

	var nested = flatToNested.convert(y);
	console.log(nested);

	//$scope.roleList = nested;
	//$scope.dataLoaded = true;

	return nested;
}



    function groupMaterialsByParent(y){
        var x = [];

        for (var i = 0; i < y.length; ++i) {
            var obj = y[i];

            //If a property for this DtmStamp does not exist yet, create
            if (x[obj.parentFolderId] === undefined)
                x[obj.parentFolderId] = []; //Assign a new array with the first element of DtmStamp.

            //x will always be the array corresponding to the current DtmStamp. Push a value the current value to it.
            x[obj.parentFolderId].push({"id" : obj.itemId, "isDirectory" : obj.isDirectory, "name" : obj.name, "url" : obj.selfUrl});
        }

        console.log("group mateirals by parent");
        console.log(x);

        var dataSet = [];

        var branch = [];

        for(var i = 0; i <= x.length; i++){
            if(x[i] != null && x[i] != undefined){
                for(var j=0;j < x[i].length; j++){
                    var r = x[i][j];
                    dataSet.push({"parentId" : i, "id" : r.id, "name" : r.name, "isDirectory":r.isDirectory, "url":r.url});
                }
            }
        }

        return dataSet;
    }

    $scope.showSelected = function(node){
    	console.log(node);
    	var SERVER_URL = "https://www3.elearning.rwth-aachen.de";
    	if(!node.isDirectory){
    		window.open(SERVER_URL + node.selfUrl, '_blank');
    	}
    }

	/* download Assignment */
    $scope.downloadAssignment = function(doc){
    	console.log(doc);
    	var SERVER_URL = "https://www3.elearning.rwth-aachen.de/";
    	var url = doc.downloadUrl.replace("assessment|", "");

    	window.open(SERVER_URL + url, '_blank');
    }


    var uploadSharedDocalert, uploadSharedDocDialog;
    $scope.uploadSharedDoc = function($event){
    // Appending dialog to document.body to cover sidenav in docs app
      uploadSharedDocDialog = $mdDialog;
      var parentEl = angular.element(document.querySelector('md-content'));
   	 $mdDialog.show({
   	   parent: parentEl,
      targetEvent: $event,
      template:
        '<md-dialog aria-label="List dialog" >' +
        '  <md-toolbar>' +
        '     <div class="md-toolbar-tools">' +
        '      <h2>Upload File</h2>' +
        '      <span flex></span>' +
        '    </div>' +
        '  </md-toolbar>' +
        '  <md-dialog-content class="sticky-container" style="padding:5px;">'+
        '    <br>'+
        '    <md-input-container style="margin-bottom:0px;">'+
        '        <label>Selected File</label>'+
        '        <input type="text" ng-model="fileName" ng-disabled=true>'+
        '    </md-input-container>'+
        '    <md-button ng-click="selectFileToUpload()" class="md-primary">' +
        '      Browse' +
        '    </md-button>' +
        '  <md-dialog-actions>' +
        '    <md-button ng-click="uploadFile()" class="md-primary">' +
        '      Upload' +
        '    </md-button>' +
        '    <md-button ng-click="closeDialog()" class="md-primary">' +
        '      Cancel' +
        '    </md-button>' +
        '  </md-dialog-actions>' +
        '</md-dialog>',
        locals: {
          items: $scope.items,
          cid: $stateParams.cid,
          closeDialog: $scope.closeDialog,
      		refresh: $scope.refresh.bind(self),
    		showSimpleToast: $scope.showSimpleToast.bind(self),

        },
        bindToController: true,
        controllerAs: 'ctrl',
        controller: 'DialogController'
    });

     // $mdDialog
     //  .show(uploadSharedDocalert)
     //  .finally(function() {
     //    uploadSharedDocalert = undefined;
     //  });
  }
  $scope.closeDialog = function() {
    uploadSharedDocDialog.hide();
  };


    $scope.getFile = function () {
        $scope.progress = 0;
        $rootScope.$broadcast('loadingFile');
        fileReader.readAsDataUrl($scope.file, $scope)
                      .then(function(result) {
                        console.log($scope.file);
                          //$scope.imageSrc = result;
                          //console.log(result);
                          $scope.selectedFile = result.split(",")[1];
                          // console.log("next one");
                           courseService.setFile($scope.file.name, $scope.selectedFile);
                          // console.log($scope.selectedFile);
                          $rootScope.$broadcast('fileLoaded');
        });
    };



  $scope.$on('showProg', function(event, args) {
  	console.log("setting to true");
	$scope.dataLoaded = false;
    // do what you want to do
});


  $scope.$on('hideProg', function(event, args) {
	$scope.dataLoaded = true;
    // do what you want to do
});

    $scope.$on('loadShareDocs', function(event, args) {
	loadAllSharedDocs();
    // do what you want to do
});


});


