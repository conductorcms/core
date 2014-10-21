// register interceptors at the app level

angular.module('admin').config(function($httpProvider)
{
	// setup http authentication interceptor
	var interceptor = function($q, $rootScope) {
		return {
			'responseError': function(rejection) {
				switch(rejection.status) {
					case 401:
						break;

				}
				return $q.reject(rejection);
			}
		}
	}

	// push new interceptor onto stack
	$httpProvider.interceptors.push(interceptor);
});