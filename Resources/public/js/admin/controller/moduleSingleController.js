app.controller('moduleSingleController',['$scope',function($scope){
	$scope.init = function(module , data ){
        $scope.setModule(module);
        $scope.data = data;
    }
}]);