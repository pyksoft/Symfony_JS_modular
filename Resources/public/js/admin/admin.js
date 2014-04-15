BASE_URL = ""

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *\
 *                          ANGULAR JS                               *
\* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
var app = angular.module("modular-admin",['ngRoute']);


// * * * ROUTING * * * 
app.config(['$routeProvider', '$locationProvider' , function( $routeProvider, $locationProvider ){
    
    // Set the routes for all the modules
    var i=0;
    var mainRoute = window.location.origin+window.location.pathname;
    for(m in MODULES){
        var M = MODULES[m];
        // MODULE PAGE
        $routeProvider.when( "/"+M.labels.name, { 
        	templateUrl : mainRoute+m
        });
        // MODULE DATA SINGLE PAGE

        $routeProvider.when( "/"+M.labels.name+"/:id", { 
            templateUrl : (function(m){ return function(params){ return mainRoute+"single/"+m+"/"+params.id;}})(m)
        });

        //default page is first modules
        if(i==0) $routeProvider.when( "/", { redirectTo : "/"+M.labels.name });
        i++;
    }

    $routeProvider.otherwise( { redirectTo : "/" });
    //$locationProvider.html5Mode(true);
}]);
// * * * SETTING ANGULAR TAGS * * * 
// (TWIG CONFLICT)
app.config(['$interpolateProvider' , function($interpolateProvider){
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
}]);