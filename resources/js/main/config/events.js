// register events at the app level

angular.module('admin').run(function($rootScope, Session, $window) {

	// when a route change starts, check permissions
	// and restrict access if user does not
	// meet lowest route permissions
	$rootScope.$on('$routeChangeStart', function(evt, next, curr) {
        var session = Session.check();

        if(next.$$route.permission !== undefined)
        {
            if(!Session.isAuthorized(next.$$route.permissions))
            {
                evt.preventDefault();
                $window.location.href = '/';
            }
        }

	});

});
