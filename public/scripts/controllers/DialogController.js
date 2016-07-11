// Dialog for uploading file
app.controller('DialogController', function($rootScope, $scope, $mdDialog, $mdToast, $timeout, fileReader, cid, courseService, Upload, refresh, showSimpleToast) {

  $scope.showFileProg = false;

   //Open hidden file dialog to select file by triggering its click event
   $scope.selectFileToUpload = function(){
    document.getElementById('upload_file').click();
  }

  //actual upload file ot server
  $scope.uploadFile = function(){
  	console.log("selected file is ");

    //getting the file from the service as it is placed there temporarily
    fileName = courseService.getFileName();
  	file = courseService.getFile();

    //broadcast event to show the progress dialog
    $rootScope.$broadcast('showProg');
    $scope.closeDialog();

    //path where to upload file
    sourceDirectory = "/ss16/" + cid + "/collaboration/Lists/SharedDocuments";

    console.log(sourceDirectory);

    // make request to server for uploading file
    Upload.upload({
      url: 'course/16ss-55492/upload_in_shared_document',
      data: {sourceDirectory:sourceDirectory, fileName: fileName, stream: file}
    }).then(function (response) {
            console.log(response);

            //remove the progress dialog
            $rootScope.$broadcast('hideProg');
            if(response.data.Status){
              $timeout(function () {
                //refresh the files list
                $rootScope.$broadcast('loadShareDocs');
                refresh();
                showSimpleToast("File uploaded successfully");
            });
            }
            else{
              refresh();
              showSimpleToast("Error Uploading file");
            }

      }, function (response) {
            if (response.status > 0) {
              refresh();
              showSimpleToast("Error Uploading file");
            }
          }, function (evt) {
      });
  }

   $scope.closeDialog = function() {
    $mdDialog.hide();
  };

  // event to call when file is about to load
  $scope.$on('loadingFile', function(event, args) {
  	console.log("setting to true");
	  $scope.showFileProg = true;
    // do what you want to do
  });

  // event to call when file is loaded
  $scope.$on('fileLoaded', function(event, args) {
	  $scope.showFileProg = false;
    $scope.fileName = courseService.getFileName();
  });

});