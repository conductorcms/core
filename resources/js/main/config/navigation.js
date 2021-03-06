angular.module('admin').config(function(NavigationProvider) {
    NavigationProvider.addItemsFromArray([
        {
            section: 'General',
            title: 'Settings',
            uri: '/admin/settings'
        },
        {
            section: 'General',
            title: 'Navigation',
            uri: '/admin/navigation'
        },
        {
            section: 'General',
            title: 'Modules',
            uri: '/admin/modules'
        },
        {
            section: 'General',
            title: 'Routes',
            uri: '/admin/routes'
        },
        {
            section: 'Widgets',
            title: 'Widgets',
            uri: '/admin/widgets'
        },
        {
            section: 'Widgets',
            title: 'Areas',
            uri: '/admin/widgets/areas'
        }
    ]);
});