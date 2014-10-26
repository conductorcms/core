angular.module('admin').config(function($routeProvider) {
	$routeProvider.when('/admin', {
		templateUrl: 'core/index.html',
		controller: 'HomeCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/modules', {
		templateUrl: 'core/modules.html',
		controller: 'ModulesCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/routes', {
		templateUrl: 'core/routes.html',
		controller: 'RoutesCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/widgets', {
		templateUrl: 'core/widgets/list.html',
		controller: 'WidgetListCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/widgets/instances', {
		templateUrl: 'core/widgets/instances.html',
		controller: 'WidgetInstancesCtrl',
		permissions: ['admin']
	});

	$routeProvider.when('/admin/widgets/areas', {
		templateUrl: 'core/widgets/areas.html',
		controller: 'WidgetAreasCtrl',
		permissions: ['admin']
	});
});