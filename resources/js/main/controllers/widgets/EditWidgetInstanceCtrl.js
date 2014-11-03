angular.module('admin').controller('EditWidgetInstanceCtrl', function ($scope, $modalInstance, Widget, WidgetInstance, instance) {

    $scope.instance = instance.data.instance;

    $scope.instance.options = JSON.parse($scope.instance.options);

    Widget.getOptions($scope.instance.widget).success(function(data)
    {
        $scope.options = data;

        for(var ii in $scope.options)
        {
            $scope.options[ii].value = $scope.instance.options[ii];
        }

    });

    $scope.save = function()
    {
        console.log($scope.instance);
    }

    $scope.cancel = function()
    {
        $modalInstance.dismiss('cancel');
    }


});