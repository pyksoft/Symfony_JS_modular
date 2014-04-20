app.controller('moduleSingleController',['$scope','$http','moduleService',function($scope , $http,moduleService){

    

    $scope.init = function(module , id ){
        $scope.setModule(module);
        $scope.id = id;
        $scope.getData(id);
    }

    $scope.save = function(module,data){
        if(!module) module = $scope.module;
        if(!data) data = $scope.data;

        moduleService.save(data,module,function(data){
            // done
        });
    }


}]);