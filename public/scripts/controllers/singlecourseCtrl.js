app.controller('singlecourseCtrl', function($scope,$stateParams,courseService,$mdDialog,tempdata) {


	console.log("course ID: " + $stateParams.cid);
	
	// courseService.getEmailbyid($stateParams.cid)
	// 	.then(function(res){
	// 		console.log("got emails");
	// 		console.log(res.dataSet);
	// 		$scope.emails = res.dataSet;
	// 	}, function(err){
	// 		console.log("Error occured : " + err);
	// 	});


	$scope.breadcrums = [''];

	$scope.learningMaterials = courseService.getAllLearningMaterials($stateParams.cid)
	.then(function(res){
		console.log("get all learningMaterials ");
		console.log(res.dataSet);
		parseLearningMaterials(res.dataSet);
		//console.log(buildHierarchy(items));​
	}, function(){
		console.log("Error occured");
	})

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


	$scope.chooseEmail = function(email){
		tempdata.addData(email);
	};

	$scope.test = function(){
	    $mdDialog.show(
	      $mdDialog.alert()
	        .clickOutsideToClose(true)
	        .title('Test')
	        .ok('Nice!')
	    );
	};

	$scope.viewEmail = function(){
	    $mdDialog.show({
	    	controller: EmailDialogController,
	      	templateUrl:'templates/viewemail.html',
	      	parent: angular.element(document.body),
	      	clickOutsideToClose:true
	    });
	};

	function EmailDialogController($scope, $mdDialog, tempdata) {
		$scope.email = tempdata.getData();
	  	$scope.back = function() {
	    	$mdDialog.hide();
	  	};
	};


	function parseLearningMaterials(y){


        $scope.dataLoaded = false;

        var dataSet = groupMaterialsByParent(y);

        console.log("dataset is ");
        console.log(dataSet);


        data = dataSet.reduce(function (r, a) {
                function getParent(s, b) {
                    return b.id === a.parentId ? b : (b.nodes && b.nodes.reduce(getParent, s));
                }

                var index = 0, node;
                if ('parentId' in a) {
                    node = r.reduce(getParent, {});
                }
                if (node && Object.keys(node).length) {
                    node.nodes = node.nodes || [];
                    node.nodes.push(a);


                } else {
                    while (index < r.length) {
                        if (r[index].parentId === a.id) {
                            a.nodes = (a.nodes || []).concat(r.splice(index, 1));
                        } else {
                            index++;
                        }
                    }
                    r.push(a);
                }
                return r;
            }, []);

        var tree = JSON.stringify(data, 0 , 0);

        elements = jQuery.parseJSON(tree);

        console.log(tree);

        $scope.dataLoaded = true;

        $scope.roleList = elements;
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
    		window.open(SERVER_URL + node.url, '_blank');
    	}
    }

});


