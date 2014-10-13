angular.module('admin.core').factory('Session', function($http)
{
    var session = {};

    session.current = {status: 'initializing'};

    session.login = function(data)
    {
        return $http.post('/admin/api/v1/session', data).success(function(data)
        {
            angular.copy(data, session.current);
        });
    };

    session.logout = function()
    {
        return $http.get('/admin/api/v1/session/destroy').success(function(data)
        {

        });
    };

    session.check = function()
    {
        return $http.get('/admin/api/v1/session').success(function(data)
        {
            angular.copy(data, session.current);
        });
    };

    session.isGuest = function()
    {

    }

    return session;


});