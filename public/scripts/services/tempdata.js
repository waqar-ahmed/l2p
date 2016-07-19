app.service('tempdata', function(){
  var savedata = {};

  var addData = function(inputdata){
    savedata = inputdata;
  }

  var getData = function(){
    return savedata;
  }

  return {addData, getData};
});