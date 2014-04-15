app.filter('capitalize', function($filter) {
    return function( s ) {
        return s.charAt(0).toUpperCase() + s.slice(1);;
    };
});