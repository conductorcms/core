//get all admin dependencies
var dependencies = getCoreAdminDependencies();

//configure interceptor, location mode, interpolators
angular.module('admin', dependencies).config(function($httpProvider, $locationProvider, $interpolateProvider) {

    //html5 mode removes /#/ for angular requests
    $locationProvider.html5Mode(true);

    //change interpolator to <% %> because of Laravel Blade conflicts
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

});

function getCoreAdminDependencies()
{
	var dependencies = [
		'admin.core',
		'admin.login',
		'ngRoute',
        'ngAnimate',
		'ui.bootstrap',
		'toaster',
		'textAngular',
        'ngDragDrop'
	];

	//get dependencies from constant defined by back-end
	for (var ii in window.modules) {
		dependencies.push(window.modules[ii]);
	}

	return dependencies;
}

