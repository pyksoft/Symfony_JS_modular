app.controller('moduleSingleController',['$scope','$http','moduleService',function($scope , $http,moduleService){

    

    $scope.init = function(module , data ){
        $scope.setModule(module);
        $scope.data = data;
    }

    $scope.save = function(module,data){
        if(!module) module = $scope.module;
        if(!data) data = $scope.data;

        moduleService.save(data,module,function(data){
            // done
        });
    }


}]);