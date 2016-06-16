app.controller('emailsCtrl', function($scope){

	$scope.accordianData = [
        {
            "heading" : "Software Project Management by abcasdsdsaads",
            "content" : "GM Holden Ltd, commonly known as Holden, is an Australian automaker that operates in Australasia and is headquartered in Port Melbourne, Victoria. The company was founded in 1856 as a saddlery manufacturer in South Australia."
        },
        {
            "heading" : "FORD",
            "content" : "The Ford Motor Company (commonly referred to as simply Ford) is an American multinational automaker headquartered in Dearborn, Michigan, a suburb of Detroit. It was founded by Henry Ford and incorporated on June 16, 1903."
        },
        {
            "heading" : "HOLDEN",
            "content" : "GM Holden Ltd, commonly known as Holden, is an Australian automaker that operates in Australasia and is headquartered in Port Melbourne, Victoria. The company was founded in 1856 as a saddlery manufacturer in South Australia."
        },
        {
            "heading" : "FORD",
            "content" : "The Ford Motor Company (commonly referred to as simply Ford) is an American multinational automaker headquartered in Dearborn, Michigan, a suburb of Detroit. It was founded by Henry Ford and incorporated on June 16, 1903."
        },
        {
            "heading" : "HOLDEN",
            "content" : "GM Holden Ltd, commonly known as Holden, is an Australian automaker that operates in Australasia and is headquartered in Port Melbourne, Victoria. The company was founded in 1856 as a saddlery manufacturer in South Australia."
        },
        {
            "heading" : "FORD",
            "content" : "The Ford Motor Company (commonly referred to as simply Ford) is an American multinational automaker headquartered in Dearborn, Michigan, a suburb of Detroit. It was founded by Henry Ford and incorporated on June 16, 1903."
        },
        {
            "heading" : "HOLDEN",
            "content" : "GM Holden Ltd, commonly known as Holden, is an Australian automaker that operates in Australasia and is headquartered in Port Melbourne, Victoria. The company was founded in 1856 as a saddlery manufacturer in South Australia."
        },
        {
            "heading" : "FORD",
            "content" : "The Ford Motor Company (commonly referred to as simply Ford) is an American multinational automaker headquartered in Dearborn, Michigan, a suburb of Detroit. It was founded by Henry Ford and incorporated on June 16, 1903."
        },
        {
            "heading" : "TOYOTA",
            "content" : "Toyota Motor Corporation is a Japanese automotive manufacturer which was founded by Kiichiro Toyoda in 1937 as a spinoff from his father's company Toyota Industries, which is currently headquartered in Toyota, Aichi Prefecture, Japan."
        }
    ];

    $scope.collapseAll = function(data) {
   for(var i in $scope.accordianData) {
       if($scope.accordianData[i] != data) {
           $scope.accordianData[i].expanded = false;   
       }
   }
   data.expanded = !data.expanded;
};

});
