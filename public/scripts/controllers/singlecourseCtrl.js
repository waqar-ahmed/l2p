app.controller('singlecourseCtrl', function($scope,$stateParams,courseService,$mdDialog,tempdata) {

	console.log("course ID: " + $stateParams.id);
	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			console.log("got emails");
			console.log(res.dataSet);
			$scope.emails = res.dataSet;
		}, function(err){
			console.log("Error occured : " + err);
		});

	$scope.breadcrums = [''];

	$scope.structure = { folders: [
		{ name: 'Folder 1', files: [{ name: 'File 1.jpg' }, { name: 'File 2.png' }], folders: [
			{ name: 'Subfolder 1', files: [{ name: 'Subfile 1.txt' }] },
			{ name: 'Subfolder 2' },
			{ name: 'Subfolder 3' }
		]},
		{ name: 'Folder 2' }
	], files: [{ name: 'File 1.gif' }, { name: 'File 2.gif' }]};

	$scope.options = {
		onNodeSelect: function (node, breadcrums) {
			$scope.breadcrums = breadcrums;
		}
	};

	$scope.options2 = {
		collapsible: false
	};

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


	$scope.announcements = [
	{
		title: 'This is an announcement.',
		createdBy: ' L2P',
		createdDate: '30/05/16 20:00',
		content:"The titles of Washed Out's breakthrough song and the first single from Paracosm share the two most important words in Ernest Greene's musical language: feel it. It's a simple request.",
	},
	];

	$scope.test = function(){
		$mdDialog.show(
	     	$mdDialog.alert()
	        .clickOutsideToClose(true)
	        .title('This is an alert title')
	        .textContent('for test.')
	        .ok('Got it!')
    	);
	}

	$scope.viewEmail = function(email,method){
		if (email === undefined)
			{selectedEmail = {};}
		else
			{selectedEmail = email;}
	    $mdDialog.show({
	    	controller: EmailDialogController,
	    	locals: {
	    		selectedEmail: selectedEmail,
	    		method: method,
	    	},
	      	templateUrl:'templates/viewemail.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:true
	    });
	};

	$scope.refreshEmails = function()
	{
	courseService.getEmailbyid($stateParams.cid)
		.then(function(res){
			console.log("get emails");
			console.log(res.dataSet);
			$scope.emails = res.dataSet;
		}, function(err){
			console.log("Error occured : " + err);
		});
	}

	function EmailDialogController($scope, $mdDialog, selectedEmail, method) {
		$scope.authWrite = false;
		$scope.authDelete = false;
		$scope.authShow = false;
		if (method == 'creat'){
			$scope.authWrite = true;
		}
		else if (method == 'read'){
			$scope.authShow = true;
		}
		else if (method == 'edit'){
			$scope.authWrite = true;
			$scope.authDelete = true;
			$scope.authShow = true;
		}
		$scope.currentemail = selectedEmail;
	  	$scope.back = function() {
	    	$mdDialog.hide();
	  	};
	};


});
