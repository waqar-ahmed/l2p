
app.controller('singlecourseCtrl', function($scope, $stateParams, courseService, $mdDialog, $window) {

	var LOGIN_PAGE = "login.html";
	var sem = $stateParams.cid.substring(2,4)+$stateParams.cid.substring(0,2);

	$scope.emailsLoaded = false;
	$scope.announcementsLoaded = false;
	$scope.$parent.authcourse = true;
	$scope.breadcrums = [''];

	if(!courseService.getAuthenticatedValue()){
		window.location = LOGIN_PAGE;
	}

	console.log("course ID: " + $stateParams.cid);

	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			console.log("got emails");
			console.log(res.dataSet);
			$scope.emails = res.dataSet;
			$scope.emailsLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
	});

	courseService.getAnnounbyid($stateParams.cid)
		.then(function(res){
			console.log("got announcements");
			console.log(res.dataSet);
			$scope.announcements = res.dataSet;
			$scope.announcementsLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
	});

	 courseService.viewUserRole($stateParams.cid)
		.then(function(res){
			console.log("got role");
			console.log(res);
			$scope.userRole = res.role.toString();
			$scope.setRole();
		}, function(err){
			console.log("Error occured : " + err);
	});

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

	$scope.learningMaterials = courseService.getAllLearningMaterials($stateParams.cid)
	.then(function(res){
		console.log("get all learningMaterials ");
		console.log(res.dataSet);
		parseLearningMaterials(res.dataSet);
		//console.log(buildHierarchy(items));
	}, function(){
		console.log("Error occured");
	})

	this.getCurrentCourse = function() {

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


	$scope.setRole = function(){
		if ($scope.userRole.indexOf("manager")!==-1){
			$scope.authCUD = true;}
		else if ($scope.userRole.indexOf("student")!==-1){
			$scope.authCUD = false;}
		console.log($scope.authCUD);
	}

	$scope.resetEmailLoading = function() {
		$scope.emailsLoaded = false;
	}

	$scope.resetAnnounLoading = function() {
		$scope.announcementsLoaded = false;
	}

	// $scope.test = function(){
	// 	$mdDialog.show(
	//      	$mdDialog.alert()
	//         .clickOutsideToClose(true)
	//         .title('This is an alert title')
	//         .textContent('for test.')
	//         .ok('Got it!')
 //    	);
	// }

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
	    	},
	    	bindToController: true,
	      	templateUrl:'templates/viewemail.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:true
	    });
	};

	$scope.deleteEmail = function(email) {
  	courseService.deleteEmail($stateParams.cid, email.itemId)
		.then(function(res){
			console.log("email is deleted");
			console.log(res);
			$scope.emailsLoaded = false;
			$window.alert("email is deleted");
			$scope.refreshEmails();
		},
		function(err){
			console.log("Error occured : " + err);
		});
  	}

	$scope.refreshEmails = function(){
	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			console.log("refresh emails");
			console.log(res.dataSet);
			$scope.emails = res.dataSet;
			$scope.emailsLoaded = true;
		},
		function(err){
			console.log("Error occured : " + err);
		});
	}

	function EmailDialogController($scope, $mdDialog, $window, courseService, selectedEmail, method, cid, resetLoading, refreshEmail) {
		$scope.authWrite = false;
		$scope.authDelete = false;
		$scope.authShow = false;
		$scope.recipients = ["extra","tutors","mangagers","students"];

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
	  		$scope.currentemail.replyTo = 'Reply to my address';
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
				$window.alert("new email is sent");
			},
			function(err){
				console.log("Error occured : " + err);
			});
	  	}
	};

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
	    		refreshAnnouns: $scope.refreshAnnouns.bind(self)

	    	},
	    	bindToController: true,
	      	templateUrl:'templates/viewannouncement.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:true
	    });
	};

	$scope.deleteAnnoun = function(announcement) {
  	courseService.deleteAnnoun($stateParams.cid, announcement.itemId)
		.then(function(res){
			console.log("announcement is deleted");
			console.log(res);
			$scope.announcementsLoaded = false;
			$window.alert("announcement is deleted");
			$scope.refreshAnnouns();
		},
		function(err){
			console.log("Error occured : " + err);
		});
	}

	$scope.refreshAnnouns = function(){
	courseService.getAnnounbyid($stateParams.cid)
		.then(function(res){
			console.log("refresh announcements");
			console.log(res.dataSet);
			$scope.announcements = res.dataSet;
			$scope.announcementsLoaded = true;
		},
		function(err){
			console.log("Error occured : " + err);
		});
	}

	function AnnounDialogController($scope, $mdDialog, $window, courseService, selectedAnnouncement, method, cid, resetLoading, refreshAnnouns) {
		$scope.authWrite = false;
		$scope.authEdit = false;
		$scope.authShow = false;

		if (method == 'creat'){
			$scope.authWrite = true;
			$scope.expireEdited = new Date();
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
			$scope.authShow = true;
			$scope.currentannoun = selectedAnnouncement;
			if ($scope.currentannoun.expireTime != 0) {
				var tempDate = new Date();
				tempDate.setTime($scope.currentannoun.expireTime*1000);
				$scope.expireEdited = tempDate;
			}
		}

	  	$scope.back = function() {
	    	$mdDialog.hide();
	  	};

	  	$scope.activeEdit = function() {
	    	$scope.authWrite = true;
	    	$scope.authEdit = false;
	  	};

	  	$scope.addAnnoun = function(){
	  		var expireTime = Math.floor($scope.expireEdited.getTime()/1000);
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
				$window.alert("new announcement is sent");
			},
			function(err){
				console.log("Error occured : " + err);
			});
	  	}

	  		$scope.editAnnoun = function(){
	  		if ($scope.expireEdited != undefined){
		  		var expireTime = Math.floor($scope.expireEdited.getTime()/1000);
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
				$window.alert("announcement is updated");
			},
			function(err){
				console.log("Error occured : " + err);
			});
	  	}
	};

	function parseLearningMaterials(y){


        $scope.dataLoaded = false;

        var dataSet = groupMaterialsByParent(y);

        console.log("dataset is ");
        console.log(dataSet);


        data = dataSet.reduce(function (r, a) {
                function getParent(s, b) {
                    return b.id === a.parentId ? b : (b.nodes && b.nodes.reduce(getParent, s));
                }

                var index = 0, node;
                if ('parentId' in a) {
                    node = r.reduce(getParent, {});
                }
                if (node && Object.keys(node).length) {
                    node.nodes = node.nodes || [];
                    node.nodes.push(a);


                } else {
                    while (index < r.length) {
                        if (r[index].parentId === a.id) {
                            a.nodes = (a.nodes || []).concat(r.splice(index, 1));
                        } else {
                            index++;
                        }
                    }
                    r.push(a);
                }
                return r;
            }, []);

        var tree = JSON.stringify(data, 0 , 0);

        elements = jQuery.parseJSON(tree);

        // console.log(tree);

        $scope.dataLoaded = true;

        $scope.roleList = elements;
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
    		window.open(SERVER_URL + node.url, '_blank');
    	}
    }
});


