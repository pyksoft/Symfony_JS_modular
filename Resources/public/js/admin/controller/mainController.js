// * * * MAIN CONTROLLER * * *
app.controller('mainController',['$scope' , '$location' , '$route' , '$http', function($scope , $location , $route , $http ){
    
    // set "current" class to current menu item
    $scope.isCurrentMenuItem = function ( path ){
       return $location.path() == path ? 'current' : '' ;
    }
     
}]);