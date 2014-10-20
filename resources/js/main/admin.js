//get all admin dependencies
var dependencies = [
    'admin.core',
    'admin.login',
    'ngRoute',
    'ui.bootstrap',
    'toaster'
];

//get dependencies from constant defined by back-end
for (var ii in window.modules) {
    dependencies.push(window.modules[ii]);
}

//configure interceptor, location mode, interpolators
angular.module('admin', dependencies).config(function($httpProvider, $locationProvider, $interpolateProvider) {

    //setup http authentication interceptor
    var interceptor = function($q, $rootScope) {
        return {
            'responseError': function(rejection) {
                switch(rejection.status) {
                    case 401:
                        break;

                }
                return $q.reject(rejection);
            }
        }
    }

    //push new interceptor onto stack
    $httpProvider.interceptors.push(interceptor);

    //html mode gets rid of /#/
    $locationProvider.html5Mode(true);

    //change interpolator because of Laravel Blade conflicts
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

});

