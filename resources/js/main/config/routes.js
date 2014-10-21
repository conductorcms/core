angular.module('admin').config(function($routeProvider) {
	$routeProvider.when('/admin', {
		templateUrl: 'core/index.html',
		controller: 'HomeCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/modules', {
		templateUrl: 'core/index.html',
		controller: 'HomeCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/routes', {
		templateUrl: 'core/index.html',
		controller: 'HomeCtrl',
		permissions: ['admin']
	});
});