app.controller('homeCtrl', function($scope, courseService, $location, fileService, Upload, $mdToast){

	//var REQUEST_USER_CODE = "rest/auth/requestUserCode";
	var LOGIN_USER = "login";
	var LOGIN_PAGE = "login.html";
	console.log("in home");

	$scope.verified = false;



	//Checking if user is authenticated or not
	courseService.isUserAuthenticated()
	.then(function(res){
		if(res.Status == true)
		{
			console.log("user is authenticated");
			verified = true;
			//getAllCourses();
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

	$scope.clickUpload = function(){
            document.getElementById('i_file').click();
        };


    $scope.uploadFIle = function(){
    	$scope.onFileSelect(fileService.getUploadedFile());
    }


         $scope.onFileSelect = function(file) {

          if(!file) return;

          console.log("in file select");

          console.log(file.name);


          $scope.showProgressBar = true;

          file.upload = Upload.upload({
            url: 'https://www3.elearning.rwth-aachen.de/_vti_bin/L2PServices/api.svc/v1/uploadInSharedDocuments?accessToken=cAZ7oZGelvnFDjQR5fJA7rrbebtf7i7i2MN0EyQcqw0R6mUDj2cKXjbbJKwbuWBW&cid=16ss-55491&sourceDirectory=test',
            data: {fileattachment: {fileName: file.name, stream: file}},
          });


          file.upload.progress(function(evt){
              console.log('percent: ' +parseInt(100.0 * evt.loaded / evt.total));
          });


          file.upload.then(function (response) {
            $timeout(function () {
              file.result = response.data;
              console.log(response);
              $mdToast.show(
                      $mdToast.simple()
                          .textContent('File uploaded successfully')
                          .position('bottom')
                          .hideDelay(3000)
               );
              console.log(response.data.item.filename);

              var filePath = String(response.data.item.filename);
              var res = filePath.split("/files/fileattachment/");
              addFileNode(res[1], filePath);
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
