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