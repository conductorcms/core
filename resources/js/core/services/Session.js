angular.module('admin.core').factory('Session', function ($http) {
    var session = {};

    session.current = { session: false };

    // attempt to establish a session
    session.login = function(data) {
        return $http.post('/session', data).success(function (data) {
            angular.copy(data, session.current);
        });
    };

    // destory current session
    session.logout = function() {
        return $http.get('/session/destroy').success(function (data) {

        });
    };

    // check and retrieve session if established
    session.check = function() {

        if(!this.current.session)
        {
            return $http.get('/session').success(function (data) {
                angular.copy(data, session.current);
            });
        }

        return this.current.user;
    };

    // check if current user is logged in
    session.isGuest = function() {
        return !this.current.session;
    }

    // check if current session has sufficient permissions
    // for requested route
    session.isAuthorized = function(permissions) {

    }

    return session;


});