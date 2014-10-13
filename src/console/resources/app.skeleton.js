angular.module('admin.##module_name##', ['ngRoute', 'admin.core']).config(function($routeProvider, NavigationProvider)
{
	$routeProvider.when('/admin/##module_name##', {
		templateUrl: '/packages/##module_package##/assets/views/index.html',
		controller: '##module_display_name##Ctrl'
	});

	NavigationProvider.addSection({
		'title': '##module_display_name##',
		'items': [
			{
				'title': 'Overview',
				'link': '/admin/##module_name##'
			}
		]
	});

});