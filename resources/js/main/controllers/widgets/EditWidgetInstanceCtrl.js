angular.module('admin').controller('EditWidgetInstanceCtrl', function ($scope, $modalInstance, Widget, WidgetInstance, instance) {

    $scope.instance = instance.data.instance;

    $scope.instance.options = JSON.parse($scope.instance.options);

    console.log($scope.instance.options);

    Widget.getOptions($scope.instance.widget).success(function(data)
    {
        $scope.options = data;

        for(var ii in $scope.options)
        {
            $scope.options[ii].value = $scope.instance.options[$scope.options[ii].slug];
        }

    });

    $scope.save = function()
    {
        for(var ii in $scope.options)
        {
            $scope.instance.options[$scope.options[ii].slug] = $scope.options[ii].value;
        }

        console.log($scope.instance);
        console.log($scope.options);
    }

    $scope.cancel = function()
    {
        $modalInstance.dismiss('cancel');
    }


});