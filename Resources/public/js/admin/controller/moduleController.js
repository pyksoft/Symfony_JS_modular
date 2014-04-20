// * * * MAIN CONTROLLER * * *
app.controller('moduleController',['$scope' , '$location' , '$route' , '$timeout','moduleService', function($scope , $location , $route , $timeout , moduleService ){
    
    $scope.setModule = function(module){
        $scope.module = module.name;
        $scope.labels = module.labels;
    }

    $scope.create = function(module){
        if(!module) module = $scope.module;
        moduleService.create(module,function(id){
            $timeout(function(){
                $scope.$apply(function() { $location.path("/"+$scope.labels.name+"/"+id);  })
            });
        });
    }

    $scope.getData = function(id , module){
        if(!module) module = $scope.module;
        if(!id) id = $scope.id;
        moduleService.get(id,module,function(data){
            $scope.data = data;
        });
    }

    $scope.getAllData = function(module){
        if(!module) module = $scope.module;
        moduleService.getAll(module,function(data){
            $scope.data = data;
        });
    }

    $scope.deleteData = function(id,module){
        if(!module) module = $scope.module;
        moduleService.delete(id,module,function(){
            $scope.getAllData();
        });
    }
     
}]);