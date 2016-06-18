app.controller('emailsCtrl', function($scope, colorService, courseService){

    $scope.dataset = {};
    $scope.courses = {};
    $scope.combinedData = [];
    $scope.colors = [];

    var sem = "ss16";
    var mins = 10080;

    courseService.getWhatsNew(mins)
        .then(function(res){
            console.log("got news");
            console.log(res.dataset);
            $scope.dataset = res.dataset;
            getCurrentSem();
        }, function(err){
            console.log("Error occured : " + err);
    });

    $scope.collapseAll = function(data) {
        for(var i in $scope.accordianData) {
            if($scope.accordianData[i] != data) {
                $scope.accordianData[i].expanded = false;
            }
        }
    data.expanded = !data.expanded;
    };


    parseDataSet = function() {
        for (var i=0; i<$scope.dataset.length; i++){
            var courseTitle = "";

            for (var j=0; j<$scope.courses.length; j++){
                if ($scope.dataset[i].cid == $scope.courses[j].uniqueid){
                    courseTitle = $scope.courses[j].courseTitle;
                }
            }

            for (var k=0; k<$scope.dataset[i].announcements.length; k++){
                var type = "announcement";
                var title = $scope.dataset[i].announcements[k].title;
                var content = $scope.dataset[i].announcements[k].body;
                var date = $scope.dataset[i].announcements[k].created;
                var abbre = "A";
                var currentData = {
                    "type": type,
                    "title": title,
                    "courseTitle": courseTitle,
                    "content": content,
                    "date": date,
                    "abbre": abbre,
                };
                $scope.combinedData.push(currentData);
            }

            for (var k=0; k<$scope.dataset[i].emails.length; k++){
                var type = "email";
                var title = $scope.dataset[i].emails[k].subject;
                var content = $scope.dataset[i].emails[k].body;
                var date = $scope.dataset[i].emails[k].created;
                var abbre = "E";
                var currentData = {
                    "type": type,
                    "title": title,
                    "courseTitle": courseTitle,
                    "content": content,
                    "date": date,
                    "abbre": abbre,
                };
                $scope.combinedData.push(currentData);
            }
        }
        console.log("data is parsed");
        console.log($scope.combinedData);
        $scope.colors = colorService.generateColors($scope.combinedData.length);
    }

    getCurrentSem = function() {
        courseService.getCurrentSem(sem)
            .then(function(res){
                console.log("got courses");
                console.log(res.dataSet);
                $scope.courses = res.dataSet;
                parseDataSet();
            }, function(err){
                console.log("Error occured : " + err);
        });
    }

    refreshNews = function() {
        $scope.combinedData = [];
        courseService.getWhatsNew(mins)
            .then(function(res){
                console.log("refresh news");
                console.log(res.dataset);
                $scope.dataset = res.dataset;
                parseDataSet();
            }, function(err){
                console.log("Error occured : " + err);
        });
    }
});
