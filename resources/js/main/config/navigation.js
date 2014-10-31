angular.module('admin').config(function(NavigationProvider) {
	NavigationProvider.addSection({
		title: 'Core',
		items: [
			{
				title: 'Settings',
				uri: '/admin/settings'
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

	NavigationProvider.addSection({
		title: 'Widgets',
		items: [
			{
				title: 'List',
				uri: '/admin/widgets'
			},
			{
				title: 'Instances',
				uri: '/admin/widgets/instances'
			},
			{
				title: 'Areas',
				uri: '/admin/widgets/areas'
			}
		]
	});
});