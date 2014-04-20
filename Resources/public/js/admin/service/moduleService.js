app.service('moduleService',['$http',function($http){
	var self = this;

	$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

	self.create = function( module , callbackSuccess , callbackError ){
		self.getQuery('create',module,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.get = function( id , module , callbackSuccess , callbackError ){
		self.getQuery('get',module+"/"+id,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.getAll = function( module , callbackSuccess , callbackError ){
		self.getQuery('getAll',module,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.save = function( data , module , callbackSuccess , callbackError ){
		self.postQuery('save',module+"/"+data.id, data, function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.delete = function( id , module , callbackSuccess , callbackError ){
		self.getQuery('delete',module+"/"+id,function(data){
			if( typeof(callbackSuccess) === 'function')
            	callbackSuccess(data);
		},function(){
			if( typeof(callbackError) === 'function')
            	callbackError();
		});
	}

	self.getQuery = function( action , params , callbackSuccess , callbackError ){
		$http.get( window.location.origin+window.location.pathname+action+'/'+params)
			.success(function(data) {
	            if( typeof(callbackSuccess) === 'function')
	            	callbackSuccess(data); 
	        })
			.error(function(data){
	        	if( typeof(callbackError) === 'function')
	            	callbackError();
	        });
	}

	self.postQuery = function( action , params , data , callbackSuccess , callbackError ){
		$http.post( window.location.origin+window.location.pathname+action+'/'+params , $.param(data) )
			.success(function(data) {
	            if( typeof(callbackSuccess) === 'function')
	            	callbackSuccess(data); 
	        })
			.error(function(data){
	        	if( typeof(callbackError) === 'function')
	            	callbackError();
	        });
	}

	return self;

}]);