angular.module('admin', ['admin.core', 'admin.battletracker', 'ngRoute', 'ui.bootstrap']).config(function($routeProvider, $locationProvider, $interpolateProvider, NavigationProvider)
{
    $routeProvider.when('/admin', {
        templateUrl: '/packages/mattnmoore/conductor/assets/views/index.html',
        controller: 'HomeCtrl'
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
            }
        ]
    });
});