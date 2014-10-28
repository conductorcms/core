angular.module('admin').controller('NewWidgetInstanceCtrl', function ($scope, $modalInstance, Widget, WidgetInstance) {

    $scope.widgets = Widget.widgets;
    $scope.buttonText = 'Select a widget';

    $scope.options = {};

    Widget.getAll();

    $scope.save = function () {
        console.log($scope.options);
        WidgetInstance.save($scope.selectedWidget, $scope.options);
        //$modalInstance.close();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

    $scope.toggleDropdown = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.status.isopen = !$scope.status.isopen;
    };

    $scope.selectWidget = function(widget)
    {
        $scope.selectedWidget = widget;
        $scope.buttonText = widget.name;
        var promise = Widget.getOptions(widget);
        promise.success(function(data)
        {
           $scope.options = data;
        });
    }

});