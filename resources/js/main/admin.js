var dependencies = [
    'admin.core',
    'admin.login',
    'ngRoute',
    'ui.bootstrap'
];

for (var ii in window.modules) {
    dependencies.push(window.modules[ii]);
}

angular.module('admin', dependencies).config(function ($routeProvider, $locationProvider, $interpolateProvider, NavigationProvider) {
    $routeProvider.when('/admin', {
        templateUrl: 'core/index.html',
        controller: 'HomeCtrl'
    });

    $routeProvider.when('/admin/modules', {
        templateUrl: 'core/modules.html',
        controller: 'ModulesCtrl'
    });

    $locationProvider.html5Mode(true);

    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

    NavigationProvider.addSection({
        'title': 'Core',
        'items': [
            {
                'title': 'Home',
                'link': '/admin'
            },
            {
                'title': 'Modules',
                'link': '/admin/modules'
            }
        ]
    });
});