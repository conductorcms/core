angular.module('admin').config(function($routeProvider, NavigationProvider)
{
    //use global helper to setup navigation and routes
    NavigationProvider.setupModuleNavigation({
        title: 'Core',
        items: [
            {
                title: 'Home',
                uri: '/admin',
                template: 'core/index.html',
                controller: 'HomeCtrl',
                permissions: [
                    'admin'
                ]
            },
            {
                title: 'Modules',
                uri: '/admin/modules',
                template: 'core/modules.html',
                controller: 'ModulesCtrl',
                permissions: [
                    'admin'
                ]
            },
            {
                title: 'Routes',
                uri: '/admin/routes',
                template: 'core/routes.html',
                controller: 'RoutesCtrl',
                permissions: [
                    'admin'
                ]
            }

        ]
    }, $routeProvider);
});

//setup session checking
angular.module('admin').run(function($rootScope) {
    $rootScope.$on('$routeChangeStart', function(evt, next, curr) {
        console.log(next.$$route.permissions);
    });
});

