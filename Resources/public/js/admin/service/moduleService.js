app.service('moduleService',['$http',function($http){
	var self = this;

	self.create = function( module , callbackSuccess , callbackError ){
		self.query('create',module,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.get = function( id , module , callbackSuccess , callbackError ){
		self.query('get',module+"/"+id,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.getAll = function( module , callbackSuccess , callbackError ){
		self.query('getAll',module,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.delete = function( id , module , callbackSuccess , callbackError ){
		self.query('delete',module+"/"+id,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.query = function( action , params , callbackSuccess , callbackError ){
		$http({
            method: 'GET', 
            url: window.location.origin+window.location.pathname+action+'/'+params
        }).success(function(data) {
            if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
        }).error(function(data){
        	if( typeof(callbackError) === 'function')
            	callbackError();
        });
	}

	return self;

}]);