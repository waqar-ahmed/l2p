app.controller('DialogController', function($rootScope, $scope, $mdDialog, $mdToast, $timeout, fileReader, cid, courseService, Upload) {
  //alert( this.closeDialog );
  //this.closeDialog = $scope.closeDialog;
  
  $scope.showFileProg = false;

   $scope.selectFileToUpload = function(){
  	console.log("test");
    document.getElementById('upload_file').click();
  }

  $scope.uploadFile = function(){
  	console.log("selected file is ");
    fileName = courseService.getFileName();
  	file = courseService.getFile();
    $rootScope.$broadcast('showProg');
    $scope.closeDialog();
    sourceDirectory = "/ss16/" + cid + "/collaboration/Lists/SharedDocuments";

    console.log(sourceDirectory);

    // if($scope.folderName.length != 0){
    //   sourceDirectory += "/" + $scope.folderName;
    // }
  	

Upload.upload({
            url: 'course/16ss-55492/upload_in_shared_document',
            data: {sourceDirectory:sourceDirectory, fileName: fileName, stream: file}
          }).then(function (response) {
            console.log(response);
            $rootScope.$broadcast('hideProg');
            if(response.data.Status){
              $timeout(function () {
                $rootScope.$broadcast('loadShareDocs');
              $mdToast.show(
                      $mdToast.simple()
                          .textContent('File uploaded successfully')
                          .position('bottom')
                          .hideDelay(3000)
               );
            });
            }
            else{
              $mdToast.show(
                      $mdToast.simple()
                          .textContent('Error Uploading file')
                          .position('bottom')
                          .hideDelay(3000)
                  );
            }
            
          }, function (response) {
            if (response.status > 0)
            $mdToast.show(
                      $mdToast.simple()
                          .textContent('Error Uploading file')
                          .position('bottom')
                          .hideDelay(3000)
                  );
          }, function (evt) {
          });




  }

   $scope.closeDialog = function() {
    $mdDialog.hide();
  };

  $scope.$on('loadingFile', function(event, args) {
  	console.log("setting to true");
	$scope.showFileProg = true;
    // do what you want to do
});


  $scope.$on('fileLoaded', function(event, args) {
	$scope.showFileProg = false;
    // do what you want to do
});


});