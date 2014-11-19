// Register items in the admin panel navigation
// menu here. Don't forget to define
// routes for your nav items.

angular.module('admin.##module_name##').config(function(NavigationProvider) {
    NavigationProvider.addItemsFromArray([
        {
            section: '##module_display_name##',
            title: 'Overview',
            uri: '/admin/##module_name##'
        }
    ]);
});


