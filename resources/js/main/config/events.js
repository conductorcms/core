// register events at the app level

angular.module('admin').run(function($rootScope) {

	// when a route change starts, check permissions
	// and restrict access if user does not
	// meet lowest route permissions
	$rootScope.$on('$routeChangeStart', function(evt, next, curr) {
		console.log(next.$$route.permissions);
	});

});
