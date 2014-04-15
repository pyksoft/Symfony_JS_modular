app.filter('twigDate', ['$filter' , function($filter) {
    return function(obj, format ) {
        return $filter('date')(obj.date.replace(" ","T"),format);
    };
}]);