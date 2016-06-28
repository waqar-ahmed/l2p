app.service('colorService', function(){


   	var candidateColors = [
    '#4183D7',
    '#59ABE3',
    '#3498DB',
    '#22A7F0',
    '#1E8BC3',
    '#6BB9F0',
    '#1F3A93',
    '#4B77BE',
    '#5C97BF',
    '#89C4F4',
    '#020360'
   ];

  this.generateColors = function(length){
    var colors = [];
    for(var i = 0; i < length; i++){
      // $scope.colors[i] = '#'+Math.floor(Math.random()*16777215).toString(16);
      colors[i] = candidateColors[getRandomInt(0 , candidateColors.length - 1)];
    }
    return colors;
  }

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }

  var dayColors = [
  '#030260',
  '#569532',
  '#AA4339',
  '#AA8D39',
  '#2D4571',
  '#DADA13',
  '#00596F'
    ];

  this.generateDayColors = function(){
     return dayColors;
  }

});
