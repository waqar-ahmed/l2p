app.controller('emailsCtrl', function($scope, $window, colorService, courseService){

    $scope.dataset = {};
    $scope.courses = {};
    $scope.combinedData = [];
    $scope.colors = [];
    $scope.emailsLoaded = false;
    $scope.dataLoaded = true;
    $scope.contentTypes = ["email", "announcement"];
    $scope.selectedType = ["email", "announcement"];
    $scope.days = [
        {
            "name": "3 days",
            "value": 3,
        },
        {
            "name": "7 days",
            "value": 7,
        },
        {
            "name": "two weeks",
            "value": 14,
        },
        {
            "name": "one month",
            "value": 30,
        },
    ];
    $scope.selectedDay = {
        "name": "3 days",
        "value": 3,
    };
    var sem = "ss16";
    var minPerDay = 1440;
    var mins = $scope.selectedDay.value* minPerDay;
    var tempmin = mins;

    if ($window.innerWidth < 435) {
         $scope.smallscreen = true;
    } else {
        $scope.smallscreen = false;
    }

    courseService.getAllWhatsNewForInbox(mins)
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

    $scope.containsComparator = function(expected, actual){
      return actual.indexOf(expected) > -1;
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
        // $scope.combinedData = orderBy($scope.combined);
        console.log("data is parsed");
        console.log($scope.combinedData);
        $scope.colors = colorService.generateColors($scope.combinedData.length);
        $scope.emailsLoaded = true;
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

    $scope.refreshNews = function(value) {
        if (mins != value* minPerDay) {
            mins = value* minPerDay;
            $scope.emailsLoaded = false;
            $scope.combinedData = [];
            courseService.getAllWhatsNew(mins)
                .then(function(res){
                    console.log("refresh news");
                    console.log(res.dataset);
                    $scope.dataset = res.dataset;
                    parseDataSet();
                }, function(err){
                    console.log("Error occured : " + err);
            });
        }
    }

});
