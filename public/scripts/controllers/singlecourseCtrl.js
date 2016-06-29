
app.controller('singlecourseCtrl', function($scope, $stateParams, courseService, $mdDialog, $window, colorService, $mdToast) {

	var LOGIN_PAGE = "login.html";
	var sem = $stateParams.cid.substring(2,4)+$stateParams.cid.substring(0,2);

	$scope.emailsLoaded = false;
	$scope.announcementsLoaded = false;
	$scope.$parent.authcourse = true;
	$scope.breadcrums = [''];
	$scope.firstLetter = "";
    $scope.colors = [];
    $scope.colors_announcement = [];

	$scope.longText = "Q: Do we need to use some specific template for the project definition document or can we write it in a free form, provided that we give answers to all the questions? (questions to answer: project background, business goals, project goals, critical success factors, assumptions, constraints, and stakeholders)";
	$scope.replyBody = "I would be interested in an answer here as well because the template from the lecture slides contains slightly different topics than the one mentioned in the assigment. Assignment: project background, business goals, project goals, critical success factors, assumptions, constraints and stakeholders.Lecure slides: project definition, project scope, objectives, project deliverables, critical success factors, assumptions, constraints, completion criteria";
	$scope.show_replies = false;


	$scope.showSimpleToast= function(message) {
    $mdToast.show(
      $mdToast.simple()
        .textContent(message)
        .position('top')
        .hideDelay(3000)
    );
 		 }

	$scope.trimFirstLetter = function(sentFrom){

    	return String(sentFrom).charAt(0);
  	
  	};



  	$scope.showConfirm = function(ev,email) {
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
    	$scope.showSimpleToast("Email has been deleted");

      
    }, function() {
			console.log("confirmation canceled");
		    });
  };

	if(!courseService.getAuthenticatedValue()){
		window.location = LOGIN_PAGE;
	}

	console.log("course ID: " + $stateParams.cid);
	/* get Emails by cid*/
	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			console.log("got emails");
			console.log(res.dataSet);
			$scope.emails = res.dataSet;
        	$scope.colors = colorService.generateColors($scope.emails.length);
			$scope.emailsLoaded = true;
		}, function(err){
			console.log("Error occured : " + err);
	});
	/* get Announcements by cid*/
	courseService.getAnnounbyid($stateParams.cid)
		.then(function(res){
			console.log("got announcements");
			console.log(res.dataSet);
			$scope.announcements = res.dataSet;
			$scope.colors_announcement = colorService.generateColors($scope.announcements.length);
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
	$scope.learningMaterials = courseService.getAllLearningMaterials($stateParams.cid)
	.then(function(res){
		console.log("get all learningMaterials ");
		console.log(res.dataSet);
		parseLearningMaterials(res.dataSet);
		//console.log(buildHierarchy(items));
	}, function(){
		console.log("Error occured");
	});


	/* get Assignments by cid*/
	courseService.getAllAssignments($stateParams.cid)
	.then(function(res){
		console.log("get all assignments ");
		console.log(res.dataSet);
		$scope.assignments = res.dataSet;
	}, function(){
		console.log("Error occured");
	});


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

	
	$scope.courseinfos = [
	{
		coursetitle: 'Introduction to Web Technology',
		description: 'A sample courseroom for sandbox usage. Additional Information SWS: 4 ECTS Credits: 7 Language: Englisch Prerequisites Knowledge in eLearning, and web/mobile technologies is recommended.',
		url: 'https://www3.elearning.rwth-aachen.de/ws12/12ws-00000',
	},
	];
	
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

	$scope.test = function() {
		console.log("test");
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
	    	},
	    	bindToController: true,
	      	templateUrl:'templates/viewemail.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:false
	    });
	};

	/* delete Email */
	$scope.deleteEmail = function(email) {
  	courseService.deleteEmail($stateParams.cid, email.itemId)
		.then(function(res){
			console.log("email is deleted");
			console.log(res);
			$scope.emailsLoaded = false;
			//$window.alert("email is deleted");
			console.log("email is deleted");
			$scope.refreshEmails();
		},
		function(err){
			console.log("Error occured : " + err);
		});
  	}
// =======
// 		var	confirmDelete = confirm("Do you want to delete the email?");
// 		if (confirmDelete == true) {
// 			courseService.deleteEmail($stateParams.cid, email.itemId)
// 			.then(function(res){
// 				console.log("email is deleted");
// 				console.log(res);
// 				$scope.emailsLoaded = false;
// 				$window.alert("email is deleted");
// 				$scope.refreshEmails();
// 			},
// 			function(err){
// 				console.log("Error occured : " + err);
// 			});
//   		}
// 	}

// >>>>>>> f37c98cf8549798fcc403b8cecbdf1fdc6dab7f5
	/* refresh Emails */
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





	function EmailDialogController($scope, $mdDialog, $window, courseService, selectedEmail, method, cid, resetLoading, refreshEmail, $mdToast) {
		$scope.authWrite = false;
		$scope.authDelete = false;
		$scope.authShow = false;
		$scope.recipients = ["extra","tutors","mangagers","students"];
		$scope.hello = "Hi";

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

	  	$scope.showSimpleToast= function(message) {
    	$mdToast.show(
      	$mdToast.simple()
        .textContent(message)
        .position('top')
        .hideDelay(3000)
    );
 		 }

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
				//$window.alert("new email is sent");
				$scope.showSimpleToast("Email has been sent!");

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
	    		refreshAnnouns: $scope.refreshAnnouns.bind(self)

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
			$scope.announcementsLoaded = false;
			//$window.alert("announcement is deleted");
			$scope.refreshAnnouns();
		},
		function(err){
			console.log("Error occured : " + err);
		});
// =======
// 		var confirmDelete = confirm("Do you want to delete the announcement?");
// 		if (confirmDelete == true) {
// 			courseService.deleteAnnoun($stateParams.cid, announcement.itemId)
// 			.then(function(res){
// 				console.log("announcement is deleted");
// 				console.log(res);
// 				$scope.announcementsLoaded = false;
// 				$window.alert("announcement is deleted");
// 				$scope.refreshAnnouns();
// 			},
// 			function(err){
// 				console.log("Error occured : " + err);
// 			});
// 		}
// >>>>>>> f37c98cf8549798fcc403b8cecbdf1fdc6dab7f5
	}

	/* refresh Announcements */
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
	
	

	function AnnounDialogController($scope, $mdDialog, $window, courseService, selectedAnnouncement, method, cid, resetLoading, refreshAnnouns,$mdToast) {
		$scope.authWrite = true;
		$scope.authEdit = true;

		$scope.authShow = false;
		$scope.announce_heading = '';
		$scope.isEdit = false;
		$scope.announce_button = '';


		$scope.showSimpleToast= function(message) {
    	$mdToast.show(
      	$mdToast.simple()
        .textContent(message)
        .position('top')
        .hideDelay(3000)
    );
 		 }


		if (method == 'creat'){
			$scope.authWrite = true;
			$scope.announce_heading = 'New Announcement';
			$scope.expireEdited = new Date();
			isEdit = false;
			$scope.announce_button = 'Add Announcement';
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
			$scope.announce_button = 'Edit Announcement';
			$scope.authShow = true;
			$scope.isEdit = true;
			$scope.currentannoun = selectedAnnouncement;
			if ($scope.currentannoun.expireTime != 0) {
				var tempDate = new Date();
				tempDate.setTime($scope.currentannoun.expireTime*1000);
				$scope.expireEdited = tempDate;
			}
		}
		// var template = angular.element($scope.currentannoun.body);
		// $scope.currentannoun.bodyEdited = $compile(template);

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
				$scope.showSimpleToast("New Announcement has been added");
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
				//$window.alert("annuncement is updated");
				$scope.showSimpleToast("Announcement has been updated");

			},
			function(err){
				console.log("Error occured : " + err);
			});
	  	}
	};


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

	$scope.roleList = nested;
	$scope.dataLoaded = true;

	return;
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
});


