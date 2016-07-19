app.controller('emailsCtrl', function($scope, $window, $q, colorService, courseService){

    $scope.dataset = {};
    $scope.courses = {};
    $scope.combinedData = [];
    $scope.colors = [];
    $scope.$parent.setNav("L2P - Inbox");
    $scope.emailsLoaded = false;
    $scope.dataLoaded = true;
    $scope.contentTypes = ["email", "announcement"];
    $scope.selectedType = ["email", "announcement"];
    var LOGIN_PAGE = "login.html";
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

    var minPerDay = 1440;
    var mins = 0;

    $scope.refreshNews = function(value) {
        if (mins != value* minPerDay) {
            mins = value* minPerDay;
            $scope.emailsLoaded = false;
            $scope.combinedData = [];
            //request created to load all data one by one
            var promises = [
                courseService.getInboxEmails(mins),
                courseService.getInboxAnnouns(mins)
            ];
            $q.all(promises).then((values) => {
            console.log("promises done");
            setInboxEmails(values[0]);
            setInboxAnnouns(values[1]);
            parseDataSet();
            });
        }
    }

    function setInboxEmails(res) {
        console.log("refresh emails");
        console.log(res);
        if(res.Status != true){
            window.location.reload();
        }
        console.log(res.Body);
        $scope.emails = res.Body;
    }

     function setInboxAnnouns(res) {
        console.log("refresh announcements");
        if(res.Status != true){
            window.location.reload();
        }
        console.log(res.Body);
        $scope.announcements = res.Body;
    }

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

    // load the initial data
    $scope.refreshNews(3);

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
        for (var k=0; k<$scope.announcements.length; k++){
            var type = "announcement";
            var title = $scope.announcements[k].title;
            var content = $scope.announcements[k].body;
            var date = $scope.announcements[k].created;
            var courseTitle = $scope.announcements[k].courseName;
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

        for (var k=0; k<$scope.emails.length; k++){
            var type = "email";
            var title = $scope.emails[k].subject;
            var content = $scope.emails[k].body;
            var date = $scope.emails[k].created;
            var courseTitle = $scope.emails[k].courseName;
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
        // $scope.combinedData = orderBy($scope.combined);
        console.log("data is parsed");
        console.log($scope.combinedData);
        $scope.colors = colorService.generateColors($scope.combinedData.length);
        $scope.emailsLoaded = true;
    }
});
