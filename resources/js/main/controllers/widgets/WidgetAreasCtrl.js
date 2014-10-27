angular.module('admin').controller('WidgetAreasCtrl', function ($scope, WidgetArea, WidgetInstance, $modal) {

	$scope.areas = WidgetArea.areas;
    $scope.instances = WidgetInstance.instances;

	WidgetArea.getAll();
    WidgetInstance.getAll();

    $scope.addArea = function()
    {
        var area = {
            name: '',
            slug: '',
            newArea: true
        };

        $scope.areas.push(area)
    }

    $scope.saveArea = function(area)
    {
        WidgetArea.save(area);
    }

    $scope.deleteArea = function(area)
    {
        $scope.areas.splice($scope.areas.indexOf(area), 1);
        if(!area.newArea)
        {
            WidgetArea.deleteArea(area);
        }
    }

    $scope.openWidgetModal = function(size)
    {
        var modalInstance = $modal.open({
            templateUrl: 'core/widgets/widgetModal.html',
            controller: 'WidgetAreaModalInstanceCtrl',
            size: size
        });
    }

    $scope.onDrop = function(data, area)
    {
        $scope.areas[$scope.areas.indexOf(area)].instances.push(data);
    }

});