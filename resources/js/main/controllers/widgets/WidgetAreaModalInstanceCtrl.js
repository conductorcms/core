angular.module('admin').controller('WidgetAreaModalInstanceCtrl', function ($scope, $modalInstance, Widget, WidgetArea) {

    $scope.widgets = Widget.widgets;
    $scope.areas = WidgetArea.areas;

    Widget.getAll();
    WidgetArea.getAll();

    $scope.save = function () {
        $modalInstance.close();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

});