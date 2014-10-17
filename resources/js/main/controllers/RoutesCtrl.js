angular.module('admin').controller('RoutesCtrl', function($scope, $http)
{
    $http.get('/admin/api/v1/routes').success(function(data)
    {
        $scope.routes = data;
    });
});