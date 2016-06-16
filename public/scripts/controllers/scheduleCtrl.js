app.controller('scheduleCtrl', function($scope,courseService,$location,$compile, $timeout, uiCalendarConfig) {
	
	var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
	$scope.dataLoading = true;

	courseService.getAllCourseEvents()
		.then(function(res){
			console.log("got all course events");
			console.log(res);
			$scope.eventSource = res.dataSet;
			for (e in $scope.eventSource){
				$scope.eventSource[e]['start'] = new Date($scope.eventSource[e].eventDate * 1000);
				$scope.eventSource[e]['end'] = new Date($scope.eventSource[e].endDate * 1000);
			}
			/* event sources array*/
			$scope.eventSources = [$scope.eventSource];
			$scope.dataLoading = false;

		}, function(err){
			console.log("Error occured : " + err);
		});
/*
	$scope.eventSource =[
	{allDay:false,endDate:1461232800,eventDate:1461220200,location:"1580|209",title:"GK 1+2.b Französisch"},
	{allDay:false,endDate:1463060700,eventDate:1463055300,location:"2354|030",title:"Mobile Internet Technology"}
	];
*/

    /* alert on eventClick */
    $scope.alertOnEventClick = function( date, jsEvent, view){
        $scope.alertMessage = (date.title + ' was clicked ');
    };
    /* alert on Drop */
     $scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
       $scope.alertMessage = ('Event Dropped to make dayDelta ' + delta);
    };
    /* alert on Resize */
    $scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
       $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
    };
    /* add and removes an event source of choice */
    $scope.addRemoveEventSource = function(sources,source) {
      var canAdd = 0;
      angular.forEach(sources,function(value, key){
        if(sources[key] === source){
          sources.splice(key,1);
          canAdd = 1;
        }
      });
      if(canAdd === 0){
        sources.push(source);
      }
    };
    /* add custom event*/
    $scope.addEvent = function() {
      $scope.events.push({
        title: 'Open Sesame',
        start: new Date(y, m, 28),
        end: new Date(y, m, 29),
        className: ['openSesame']
      });
    };
    /* remove event */
    $scope.remove = function(index) {
      $scope.events.splice(index,1);
    };
    /* Change View */
    $scope.changeView = function(view,calendar) {
      uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
    };
    /* Change View */
    $scope.renderCalender = function(calendar) {
      $timeout(function() {
        if(uiCalendarConfig.calendars[calendar]){
          uiCalendarConfig.calendars[calendar].fullCalendar('render');
        }
      });
    };
     /* Render Tooltip */
    $scope.eventRender = function( event, element, view ) {
        element.attr({'tooltip': event.title +" "+event.location,
                      'tooltip-append-to-body': true});
        $compile(element)($scope);
    };

	/* config object */
    $scope.uiConfig = {
      calendar:{
        height: 450,
        editable: true,
        header:{
          left: 'title',
          center: '',
          right: 'today prev,next'
        },
        eventClick: $scope.alertOnEventClick,
        eventDrop: $scope.alertOnDrop,
        eventResize: $scope.alertOnResize,
        eventRender: $scope.eventRender
      }
    };
	
});