app.controller('homeCtrl', function($scope, courseService, $location, fileService, Upload, $mdToast){

	//var REQUEST_USER_CODE = "rest/auth/requestUserCode";
	var LOGIN_USER = "login";
	var LOGIN_PAGE = "login.html";
	console.log("in home");

	$scope.verified = false;


	




$(function() {
    $(document).on("click","#left ul.nav li.parent > a > span.sign", function(){          
        $(this).find('i:first').toggleClass("icon-minus");      
    }); 
    
    // Open Le current menu
    $("#left ul.nav li.parent.active > a > span.sign").find('i:first').addClass("icon-minus");
    $("#left ul.nav li.current").parents('ul.children').addClass("in");
});

// !function ($) {
    
//     // Le left-menu sign
//     /* for older jquery version
//     $('#left ul.nav li.parent > a > span.sign').click(function () {
//         $(this).find('i:first').toggleClass("icon-minus");
//     }); */
    
//     $(document).on("click","#left ul.nav li.parent > a > span.sign", function(){          
//         $(this).find('i:first').toggleClass("icon-minus");      
//     }); 
    
//     // Open Le current menu
//     $("#left ul.nav li.parent.active > a > span.sign").find('i:first').addClass("icon-minus");
//     $("#left ul.nav li.current").parents('ul.children').addClass("in");

// }(window.jQuery);





























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


	$scope.lastdays = [
          "Last Day",
          "Last 7 Days",
          "Last 15 Days",
          "Last 30 Days"
    ];
	  
	  
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
    	courseService.getAllWhatsNew(mins)
    	.then(function(res){
		if(res.Status == true){
			console.log(res.dataset);
			bindData(res.dataset);
		}
		else{
		}
	}, function(err){
		console.log("Error occured : " + err);
	});
    }



    $scope.loadWhatsNew(1);

    $scope.updateList = function(lastday){
    	var day = 0;
    	if(lastday === $scope.lastdays[0]){
    		console.log(1);
    		day = 1;
    	}
    	else if(lastday === $scope.lastdays[1]){
    		console.log(7);
    		day = 7;
    	}
    	else if(lastday === $scope.lastdays[2]){
    		console.log(15);
    		day = 15;
    	}
    	else if(lastday === $scope.lastdays[3]){
    		console.log(30);
    		day = 30;
    	}
    	else{
    		console.log("error");
    	}
    	loadWhatsNew(day);
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

		
/* 	$scope.structure = { folders: [
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
	}; */
	
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
