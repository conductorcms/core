angular.module('admin').controller('RoutesCtrl', function($scope, routes)
{

    $scope.routes = routes.data;

});