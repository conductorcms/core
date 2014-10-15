angular.module('admin').controller('ModulesCtrl', function ($scope, Module) {
    Module.getAll();

    $scope.$watch(function () {
        return Module.modules
    }, function (newValue, oldValue) {
        $scope.modules = newValue;

        console.log($scope.modules);
    });
});