// * * * MAIN CONTROLLER * * *
app.controller('mainController',['$scope' , '$location' , '$route' , '$http', function($scope , $location , $route , $http ){
    
    // set "current" class to current menu item
    $scope.isCurrentMenuItem = function ( path ){
		var rgx = new RegExp(path+"(\/[^ ]+)*");
		return rgx.test( $location.path() ) ? 'current' : '' ;
    }
     
}]);