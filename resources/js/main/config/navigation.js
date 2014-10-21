angular.module('admin').config(function(NavigationProvider) {
	NavigationProvider.addSection({
		title: 'Core',
		items: [
			{
				title: 'Home',
				uri: '/admin'
			},
			{
				title: 'Modules',
				uri: '/admin/modules'
			},
			{
				title: 'Routes',
				uri: '/admin/routes'
			}
		]
	});
});