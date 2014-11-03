angular.module('admin').controller('WidgetAreasCtrl', function ($scope, WidgetArea, WidgetInstance, $modal) {

	$scope.areas = WidgetArea.areas;
    $scope.instances = WidgetInstance.instances;

    $scope.addArea = function()
    {
        var area = {
            name: '',
            slug: '',
            newArea: true
        };

        $scope.areas.push(area)
    };

    $scope.saveArea = function(area)
    {
        WidgetArea.save(area);
    };

    $scope.deleteArea = function(area)
    {
        $scope.areas.splice($scope.areas.indexOf(area), 1);
        if(area.newArea == 'undefined' || !area.newArea)
        {
            WidgetArea.deleteArea(area);
        }
    };

    $scope.openWidgetModal = function(size)
    {
        var modalInstance = $modal.open({
            templateUrl: 'core/widgets/widgetModal.html',
            controller: 'WidgetAreaModalInstanceCtrl',
            size: size
        });
    };

    $scope.onDrop = function(data, area)
    {
        var areaIndex = $scope.areas.indexOf(area);

        $scope.areas[areaIndex].widget_instances.push(data);

        var currentIds = [];
        for(var ii in $scope.areas[areaIndex].widget_instances)
        {
            currentIds.push($scope.areas[areaIndex].widget_instances[ii].id)
        }

        WidgetArea.syncInstances(area.id, currentIds);
    };

    $scope.removeInstance = function(instance, area) {
        var areaIndex = $scope.areas.indexOf(area);
        var instanceIndex = $scope.areas[areaIndex].widget_instances.indexOf(instance);

        $scope.areas[areaIndex].widget_instances.splice(instanceIndex, 1);

        var currentIds = [];
        for(var ii in $scope.areas[areaIndex].widget_instances)
        {
            currentIds.push($scope.areas[areaIndex].widget_instances[ii].id)
        }

        WidgetArea.syncInstances(area.id, currentIds);
    };

    $scope.newInstance = function()
    {
        var modalInstance = $modal.open({
            templateUrl: 'core/widgets/instances/create.html',
            controller: 'NewWidgetInstanceCtrl',
            size: 'lg'
        });
    };

    $scope.editInstance = function(instance)
    {
        var modalInstance = $modal.open({
            templateUrl: 'core/widgets/instances/edit.html',
            controller: 'EditWidgetInstanceCtrl',
            size: 'lg',
            resolve: {
                instance: function(WidgetInstance)
                {
                    return WidgetInstance.find(instance.id);
                }
            }
        });
    };

    $scope.destroyInstance = function(instance)
    {
        WidgetInstance.destroy(instance.id);
    };

});