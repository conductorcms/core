angular.module('admin.login').controller('LoginCtrl', function ($scope, Session) {
    $scope.session = Session.current;

    Session.check();

    $scope.login = function () {
        $scope.loggingIn = true;

        var login = Session.login({email: $scope.user.email, password: $scope.user.password});

        login.success(function(data)
        {
            $scope.loggingIn = false;
            if (data.session == true) window.location = '/admin';
        });
    }


});