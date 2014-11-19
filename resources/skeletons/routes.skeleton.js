// register your admin panel routes. Views automatically get stored in the
// template cache with a key of ##module_name##/{view-path}.html

angular.module('admin.##module_name##').config(function($routeProvider) {

	$routeProvider.when('/admin/##module_name##', {
		templateUrl: '##module_name##/index.html',
		controller: '##module_display_name##Ctrl',
		permissions: ['##module_name##']
	});

});
