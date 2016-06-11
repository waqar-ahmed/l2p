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


	$scope.str = { 
						folders: [
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
        console.log(node);
        console.log(breadcrums);
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

var x = [];

for (var i = 0; i < y.length; ++i) {
    var obj = y[i];

    //If a property for this DtmStamp does not exist yet, create
    if (x[obj.parentFolderId] === undefined)
        x[obj.parentFolderId] = []; //Assign a new array with the first element of DtmStamp.

    //x will always be the array corresponding to the current DtmStamp. Push a value the current value to it.
    x[obj.parentFolderId].push({"id" : obj.itemId, "isDirectory" : obj.isDirectory, "name" : obj.name});
}


var dataSet = [];

var branch = [];	

for(var i = 0; i <= x.length; i++){
	if(x[i] != null && x[i] != undefined){
		for(var j=0;j < x[i].length; j++){
			// console.log(i);
			// console.log(x[i][j]);
			var r = x[i][j];

			dataSet.push({"parentId" : i, "id" : r.id, "name" : r.name, "isDirectory":r.isDirectory});
		}
	}
}


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

var tree = JSON.stringify(data, 0 , 4);


$scope.roleList = tree.trim();

$scope.roleList = [
    {
        "parentId": 1,
        "id": 1,
        "name": "01_Introduction.pptx",
        "isDirectory": false
    },
    {
        "parentId": 2,
        "id": 2,
        "name": "02_Project_Management_Foundations.pptx",
        "isDirectory": false
    },
    {
        "parentId": 3,
        "id": 3,
        "name": "03_Software_Dev_Processes.Overview.pptx",
        "isDirectory": false
    },
    {
        "parentId": 4,
        "id": 4,
        "name": "04_Software_Dev_Processes.RUP.pptx",
        "isDirectory": false
    },
    {
        "parentId": 5,
        "id": 5,
        "name": "05_Software_Dev_Processes.Agile_Processes.pptx",
        "isDirectory": false
    },
    {
        "parentId": 6,
        "id": 6,
        "name": "06_Project_Initiation.pptx",
        "isDirectory": false
    },
    {
        "parentId": 7,
        "id": 7,
        "name": "07_Team Leadership.pptx",
        "isDirectory": false
    },
    {
        "parentId": 8,
        "id": 8,
        "name": "08_Stakeholder_Management.pptx",
        "isDirectory": false
    },
    {
        "parentId": 9,
        "id": 9,
        "name": "09_Planning.Foundation.pptx",
        "isDirectory": false
    },
    {
        "parentId": 10,
        "id": 10,
        "name": "10_Planing.Cost_Estimation.pptx",
        "isDirectory": false
    },
    {
        "parentId": 11,
        "id": 11,
        "name": "11_Planing.Scheduling.pptx",
        "isDirectory": false
    },
    {
        "parentId": 12,
        "id": 12,
        "name": "12_Monitoring and Controlling.pptx",
        "isDirectory": false
    },
    {
        "parentId": 13,
        "id": 13,
        "name": "13_Risk Management.pptx",
        "isDirectory": false
    },
    {
        "parentId": 14,
        "id": 14,
        "name": "Exercises",
        "isDirectory": true,
        "nodes": [
            {
                "parentId": 14,
                "id": 17,
                "name": "Exercise01.pdf",
                "isDirectory": false
            }
        ]
    },
    {
        "parentId": 18,
        "id": 18,
        "name": "14_Summary.pdf",
        "isDirectory": false
    }
];

console.log($scope.roleList);


	}

});


