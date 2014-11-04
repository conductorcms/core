angular.module('admin').config(function($routeProvider) {

    $routeProvider.when('/admin', {
		templateUrl: 'core/index.html',
		controller: 'HomeCtrl',
		permissions: ['admin']
	});

    $routeProvider.when('/admin/settings', {
        templateUrl: 'core/settings.html',
        controller: 'SettingsCtrl',
        resolve: {
            settings: function(Setting)
            {
                return Setting.getAll();
            }
        },
        permissions: ['admin']
    });

    $routeProvider.when('/admin/navigation', {
        templateUrl: 'core/navigation/list.html',
        controller: 'NavigationCtrl',
        permissions: ['admin']
    });


    $routeProvider.when('/admin/modules', {
		templateUrl: 'core/modules.html',
		controller: 'ModulesCtrl',
        resolve: {
            modules: function(Module)
            {
                return Module.getAll();
            }
        },
		permissions: ['admin']
	});

	$routeProvider.when('/admin/routes', {
		templateUrl: 'core/routes.html',
		controller: 'RoutesCtrl',
        resolve: {
            routes: function($http)
            {
                return $http.get('/admin/api/v1/routes');
            }
        },
		permissions: ['admin']
	});

	$routeProvider.when('/admin/widgets', {
		templateUrl: 'core/widgets/list.html',
		controller: 'WidgetListCtrl',
        resolve: {
            widgets: function(Widget)
            {
                return Widget.getAll();
            }
        },
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
        resolve: {
            areas: function(WidgetArea)
            {
                return WidgetArea.getAll();
            },
            instances: function(WidgetInstance)
            {
                return WidgetInstance.getAll();
            }
        },
		permissions: ['admin']
	});
});