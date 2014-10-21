// register events at the app level

angular.module('admin').run(function($rootScope, Session) {

	// when a route change starts, check permissions
	// and restrict access if user does not
	// meet lowest route permissions
	$rootScope.$on('$routeChangeStart', function(evt, next, curr) {
        var session = Session.check();

        if(!Session.isAuthorized(next.$$route.permissions))
        {
            console.log('not authorized');
        }
        else
        {
            console.log('authorized');
        }
	});

});
