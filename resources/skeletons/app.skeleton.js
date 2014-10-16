angular.module('admin.##module_name##', ['ngRoute', 'admin.core', 'admin.##module_name##.templates']).config(function ($routeProvider, NavigationProvider) {
    $routeProvider.when('/admin/##module_name##', {
        templateUrl: '##module_name##/index.html',
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