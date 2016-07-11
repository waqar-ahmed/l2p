//when app will start, this controller will load first
app.controller('homeCtrl', function($scope, courseService, $location, fileService, Upload, $mdToast, $timeout, fileReader){

	var LOGIN_USER = "login";
	var LOGIN_PAGE = "login.html";
	console.log("in home");

	$scope.verified = false;
	$scope.dataLoaded = false;
  $scope.$parent.setNav("L2P - Dashboard");


	//Checking if user is authenticated or not
	courseService.isUserAuthenticated()
	.then(function(res){
		if(res.Status == true)
		{
			console.log("user is authenticated");
		}
		else{
			//user is not authenticated, therefore we need to redirect user to /requestUserCode page so user can verify application
			//requestUserCode();
			gotoAuthorizePage();
		}
	}, function(err){
		console.log("Error occured : " + err);
	});

  //redirect user to RWTH authorization page
	gotoAuthorizePage = function(){
		window.location = LOGIN_PAGE;
	}

  //data to load by days
	$scope.lastdays = [
          "3 Days",
          "7 Days",
          "two weeks",
          "one month"
  ];

  //default selection to load data
  $scope.selectedDay = ["3 Days"];  

	$scope.breadcrums = [''];


  //load whats new data method
  $scope.loadWhatsNew = function(day){
    	var mins;
    	if(day > 0){
    		mins = day * 24 * 60;  // day * hours * minutes
    	}
    	else{
    		return;
    	}
    	console.log("loading data for mins : " +mins);
    	$scope.allWhatsNew = [];
    	$scope.dataLoaded = false;
    	courseService.getAllWhatsNew(mins)
    	.then(function(res){
  			console.log(res);
        // hide the progress bar once data is loaded
  			$scope.dataLoaded = true;
  			$scope.allWhatsNew = res;

        //bind data to the view
  			for (var key in res) {
  				if (res.hasOwnProperty(key)) {
  					console.log(key + " = " + res[key]);
  				}
  			}
	    }, function(err){
      		console.log("Error occured : " + err);
      		//recover from error
      		$mdToast.show(
      		$mdToast.simple()
      		.textContent("Error occured, please login again!")
      		.position('top')
      		.hideDelay(1200)
      		);
      	  courseService.logout();
            window.location = LOGIN_PAGE;
      });
  }

  // call whats new method to load data
  $scope.loadWhatsNew(3);

  //load new data based on days user selected
  $scope.updateList = function(lastday){
    	var day = 0;
    	if(lastday === $scope.lastdays[0]){
    		console.log(1);
    		day = 3;
    	}
    	else if(lastday === $scope.lastdays[1]){
    		console.log(7);
    		day = 7;
    	}
    	else if(lastday === $scope.lastdays[2]){
    		console.log(14);
    		day = 14;
    	}
    	else if(lastday === $scope.lastdays[3]){
    		console.log(30);
    		day = 30;
    	}
    	else{
    		console.log("error");
    	}
    	$scope.loadWhatsNew(day);
  }

  //download file if user click something on whats new
  $scope.downloadFile = function(subitem){
    	var SERVER_URL = "https://www3.elearning.rwth-aachen.de";
    	window.open(SERVER_URL + subitem.selfUrl, '_blank');
  }

});
