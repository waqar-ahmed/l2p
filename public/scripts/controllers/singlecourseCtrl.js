
app.controller('singlecourseCtrl', function($q, $rootScope, $scope, $stateParams, $filter, courseService, $mdDialog, $window, colorService, $mdToast, $timeout, fileReader) {

	var LOGIN_PAGE = "login.html";
	// parse cid to the correct format to get coursesinfo
	var sem = $stateParams.cid.substring(2,4)+$stateParams.cid.substring(0,2);
	var orginalDiscussions = [];
	var countDisucussions = 0;
	var transferArray = [];
	// boolean variables for loading icon
	$scope.discussLoaded = false;
	$scope.emailsLoaded = false;
	$scope.announcementsLoaded = false;
	$scope.$parent.authcourse = true;
	// variable to hide the fab button on the bottom right
	$scope.WaitForToast = true;
	$scope.breadcrums = [''];
	$scope.discussions = [];

	$scope.firstLetter = "";
	// arrays for color services
    $scope.colors_email = [];
    $scope.colors_announcement = [];

	$scope.show_replies = false;
	$scope.dataLoaded = false;
	//request created to load all data one by one
	var promises = [
		courseService.getAllLearningMaterials($stateParams.cid),
		courseService.getAllAssignments($stateParams.cid),
		courseService.getAllSharedDocs($stateParams.cid),
		courseService.getAllDiscussions($stateParams.cid),
		courseService.getEmailbyid($stateParams.cid),
		courseService.getAnnounbyid($stateParams.cid)
	];

	// all requested executed to load data
	$q.all(promises).then((values) => {
		console.log("promises done");
	    setLearningMaterials(values[0]);
	    setAssignments(values[1]);
	    setSharedDocs(values[2]);
	    setDiscussions(values[3]);
	    setEmails(values[4]);
	    setAnnouncements(values[5]);

	    $scope.dataLoaded = true;
	});

	//bind all learning material to view
	function setLearningMaterials(res){
		if(res.Status === undefined){
				window.location.reload();
			}

		if(res.dataSet === undefined || res.dataSet.length == 0){
			console.log("no Learning Materials");
			$scope.roleList = undefined;
		}else{
			console.log("get all learningMaterials ");
			console.log(res.dataSet);
			$scope.roleList = parseLearningMaterials(res.dataSet);
		}
	}

	//bind all assignments to view
	function setAssignments(res){
		if(res.Status === undefined){
			window.location.reload();
		}

		if(res.dataSet === undefined || res.dataSet.length == 0){
			console.log("no assignments");
			$scope.assignments = undefined;
		}else{
			console.log("get all assignments ");
			console.log(res.dataSet);
			$scope.assignments = res.dataSet;
			console.log("Assingment length: "+ $scope.assignments.length);
		}
	}

	//bind all shared docs to view
	function setSharedDocs(res){
		if(res.Status === undefined){
				window.location.reload();
		}

		if(res.dataSet === undefined ||res.dataSet.length == 0){
			console.log("no Share Docs")
			$scope.allSharedDocs = undefined;
		}
		else{
			console.log("get all shared Docs");
			console.log(res.dataSet);
			$scope.allSharedDocs = parseLearningMaterials(res.dataSet);
		}
	}

	//bind all discussions to view
	function setDiscussions(res){
		if(res.Status == false){
			errorRecover();
		}else if(res.Status === undefined){
			window.location.reload();
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
	}

	//bind all emails to view
	function setEmails(res){
		if(res.Status === undefined){
			window.location.reload();
		}

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
	}

	//bind all announcments to view
	function setAnnouncements(res){
		if(res.Status === undefined){
			window.location.reload();
		}
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
	}

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
	/* get Courses by sem, used for the quick switch button*/
	courseService.getCurrentSem(sem)
		.then(function(res){
			if(res.Status === undefined){
				window.location.reload();
			}

			console.log("got course by currentsemester");
			console.log(res.dataSet);
			$scope.$parent.courseinfo = res.dataSet;
			// delete the current course from course list
			var currentCourse = $.grep($scope.$parent.courseinfo, function(n,i) {
  				return n.uniqueid === $stateParams.cid;
			});
			$scope.$parent.filterid = currentCourse[0].uniqueid;
			console.log($scope.$parent.filterid);
			$scope.$parent.setNav(currentCourse[0].courseTitle);
		}, function(err){
			console.log("Error occured : " + err);
	});


	//load all shared docs and bind to view - it is used to refresh all shared docs after uploading new file
	function loadAllSharedDocs(){
		/* get Shared Docs by cid*/
		courseService.getAllSharedDocs($stateParams.cid)
		.then(function(res){
			if(res.Status === undefined){
					window.location.reload();
				}

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

	//show inform message at the bottom
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

  	// if user role is manager, change the permission
	$scope.setRole = function(){
		if ($scope.userRole.indexOf("manager")!==-1){
			$scope.authCUD = true;}
		else if ($scope.userRole.indexOf("student")!==-1){
			$scope.authCUD = false;}
		console.log($scope.authCUD);
	}

	// $scope.test = function() {
	// 	console.log("test");
	// }

	// parse the discussions data to a easy used form
	$scope.parseDiscuss = function() {
		var index = 0;
		for (var i=countDisucussions; i<orginalDiscussions.length; i++){
			// get all root discussions
			if (orginalDiscussions[i].selfId == orginalDiscussions[i].parentDiscussionId) {
				// an Array to store the index of root discussions in the new array
				var tempArray = {
					"selfId": orginalDiscussions[i].selfId,
					"value": index,
				};
				index++;
				transferArray.push(tempArray);
				orginalDiscussions[i].counts = 0;
				$scope.discussions.push(orginalDiscussions[i]);
			}
			// solve the children discussions
			else {
				var master = $filter('filter')(transferArray,{'selfId':orginalDiscussions[i].parentDiscussionId})[0].value;
				if ($scope.discussions[master].children == undefined) {
					$scope.discussions[master].children = [];
				}
				if (orginalDiscussions[i].replyToId!=orginalDiscussions[i].parentDiscussionId) {
					// store the infomration of parent post for Reply
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

	/* add Discussion */
	$scope.addDiscussion = function(){
	    $mdDialog.show({
	    	controller: DiscussionDialogController,
	    	locals: {
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

	/* add Discussion Reply*/
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

	/* delete Discussion */
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

	/* reset the loading icon to be false */
	$scope.resetDiscussLoading = function() {
		$scope.discussLoaded = false;
	}

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

	/* reset the loading icon to be false */
	$scope.resetEmailLoading = function() {
		$scope.emailsLoaded = false;
	}

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

	/* reset the loading icon to be false */
	$scope.resetAnnounLoading = function() {
		$scope.announcementsLoaded = false;
	}

	/* hide the fab button when confirm information is shown*/
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

    //this method will called when user will select to upload file
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
  }

  // close file select dialog
  $scope.closeDialog = function() {
    uploadSharedDocDialog.hide();
  };

  //get file and place it in course service so we can get file in dialog controller to uplaod
  $scope.getFile = function () {
        $scope.progress = 0;
        $rootScope.$broadcast('loadingFile');
        fileReader.readAsDataUrl($scope.file, $scope)
        .then(function(result) {
            console.log($scope.file);
            $scope.selectedFile = result.split(",")[1];
            courseService.setFile($scope.file.name, $scope.selectedFile);
            $rootScope.$broadcast('fileLoaded');
        });
  };

  // show progress bar when data is uploading to server - this event will be called from dialog controller when file is uploading
  $scope.$on('showProg', function(event, args) {
  	console.log("setting to true");
	$scope.dataLoaded = false;
    // do what you want to do
  });

  //hide progress bar once data is loaded - this event will called from dialog controller after uploading file finished
  $scope.$on('hideProg', function(event, args) {
	$scope.dataLoaded = true;
    // do what you want to do
  });

  // when file is uplaoded then refresh the shared docs - this event will be called from dialog controller when file is uploaded to server
  $scope.$on('loadShareDocs', function(event, args) {
	loadAllSharedDocs();
    // do what you want to do
  });
});


