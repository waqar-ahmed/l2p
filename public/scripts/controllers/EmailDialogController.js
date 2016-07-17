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