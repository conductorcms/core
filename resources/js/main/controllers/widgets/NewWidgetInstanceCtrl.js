angular.module('admin').controller('NewWidgetInstanceCtrl', function ($scope, $modalInstance, Widget, WidgetInstance) {

    $scope.widgets = Widget.widgets;
    $scope.buttonText = 'Select a widget';

    $scope.options = {};

    Widget.getAll();

    $scope.save = function(instance) {

        var options = {};

        for(var key in $scope.options)
        {
            console.log(key);
            options[key] = $scope.options[key].value;
        }

        var data = {
            options: options,
            name: instance.name,
            slug: instance.slug
        };

        WidgetInstance.save($scope.selectedWidget, data);

        $modalInstance.close();
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