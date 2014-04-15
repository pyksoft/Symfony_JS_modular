app.controller('moduleListController',['$scope','$filter',function($scope,$filter){
	
	$scope.init = function(module , columns){
        $scope.setModule(module);
        $scope.columns = columns;
        $scope.getAllData();
    }

    $scope.getListValue = function(data,col){
    	if(col.type == 'date')
    		return $filter('twigDate')(data[col.name],'medium');
    	else if(col.type == 'label')
    		return $scope.labels[data[col.name]];
    	else
    		return data[col.name];
    }
    
}]);