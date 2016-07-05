app.controller('homeCtrl', function($scope, courseService, $location, fileService, Upload, $mdToast, $timeout, fileReader){

	//var REQUEST_USER_CODE = "rest/auth/requestUserCode";
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


	gotoAuthorizePage = function(){
		window.location = LOGIN_PAGE;
	}

	// Redirect user to request user code page so user can verify all courses
	requestUserCode = function(){
		window.location = LOGIN_USER;
	}


	$scope.lastdays = [
          "3 Days",
          "7 Days",
          "two weeks",
          "one month"
    ];

  $scope.selectedDay = ["3 Days"];  

	$scope.breadcrums = [''];


    $scope.tree = [{
        id: 1,
        fname: "tree",
        child: [{
            id: 1,
            fname: "example"
        }],
        lname: "grid"
    }];




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
			$scope.dataLoaded = true;
			$scope.allWhatsNew = res;
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



    $scope.loadWhatsNew(3);

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

    bindData = function(data){
    	var allEmails=[];
    	var allAnnouncements=[];
    	var allLearningMaterials=[];
    	var discussionForum=[];
    	console.log(data);
    	console.log("in bind data");
    	for(var i=0; i < data.length; i++){
    		console.log("i loop");
    		console.log(data[i]);
    		if(data[i].emails.length > 0){
    			for(var j=0;j<data[i].emails.length;j++){
    				console.log(data[i].emails[j].subject);
    			}
    		}
    	}
    }

    $scope.downloadFile = function(subitem){
    	var SERVER_URL = "https://www3.elearning.rwth-aachen.de";
    	// var url = doc.downloadUrl.replace("assessment|", "");
    	window.open(SERVER_URL + subitem.selfUrl, '_blank');
    }



function readTextFile(file)
{
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                alert(allText);
            }
        }
    }
    rawFile.send(null);
}




	$scope.clickUpload = function(){
            document.getElementById('i_file').click();
        };

    $scope.getFile = function () {
        $scope.progress = 0;
        fileReader.readAsDataUrl($scope.file, $scope)
                      .then(function(result) {
                        console.log($scope.file);
                          //$scope.imageSrc = result;
                          console.log(result);
                          result = result.split(",")[1];
                          console.log("next one");
                          console.log(result);
                           $scope.onFileSelect(result);
                      });
    };

    $scope.$on("fileProgress", function(e, progress) {
        $scope.progress = progress.loaded / progress.total;
    });


    $scope.uploadFIle = function(){
    	$scope.onFileSelect(fileService.getUploadedFile());
    }


         $scope.onFileSelect = function(file) {

          if(!file) return;

          console.log("in file select");

          //console.log(file.name);
          //console.log(file.toString());


          $scope.showProgressBar = true;

          // var strStream = "";
          // streamToString(file, (data) => {
          //   console.log(data);
          //   strStream = data;  // data is now my string variable
          // });

          // file.upload = Upload.upload({
          //   url: 'course/16ss-55492/upload_in_shared_document',
          //   data: {fileName: file.name, stream: file}
          // });


          // file.upload.progress(function(evt){
          //     console.log('percent: ' +parseInt(100.0 * evt.loaded / evt.total));
          // });
Upload.upload({
            url: 'course/16ss-55492/upload_in_shared_document',
            data: {sourceDirectory:"/ss16/16ss-55492/collaboration/Lists/SharedDocuments", fileName: $scope.file.name, stream: file}
          }).then(function (response) {
            $timeout(function () {
              file.result = response.data;
              console.log(response);
              $mdToast.show(
                      $mdToast.simple()
                          .textContent('File uploaded successfully')
                          .position('bottom')
                          .hideDelay(3000)
               );
              $scope.showProgressBar = false;
            });
          }, function (response) {
            if (response.status > 0)
              $scope.errorMsg = response.status + ': ' + response.data;
            console.log("in response");
            console.log(response);
            $mdToast.show(
                      $mdToast.simple()
                          .textContent('Error Uploading file')
                          .position('bottom')
                          .hideDelay(3000)
                  );
            $scope.showProgressBar = false;
          }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            console.log(file.progress);
            $scope.progressBarValue = file.progress;
          });

}

});
