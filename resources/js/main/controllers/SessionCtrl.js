angular.module('admin').controller('SessionCtrl', function ($scope, Session) {
    $scope.session = Session.current;

    var check = Session.check();
    check.then(function()
    {

    });

    $scope.logout = function()
    {
        var logout = Session.logout();

        logout.then(function()
        {
            window.location = '/admin/login';
        });
    }

});