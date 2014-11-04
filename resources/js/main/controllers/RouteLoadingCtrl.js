angular.module('admin').controller('RouteLoadingCtrl', function($scope) {
    $scope.loading = false;

    $scope.$on('$routeChangeStart', function(next, current) {
        $scope.loading = true;
    });
    $scope.$on('$routeChangeSuccess', function(next, current) {
        $scope.loading = false;
    });



});