angular.module('admin').factory('WidgetArea', function ($http) {
	var area = {};

	area.areas = [];

	area.getAll = function()
	{
		return $http.get('/admin/api/v1/widget/areas').success(function(data)
		{
			angular.copy(data.areas, area.areas);
		});
	}

    area.save = function(properties)
    {
        $http.post('/admin/api/v1/widget/areas', properties).success(function()
        {
           area.refresh();
        });
    }

    area.deleteArea = function(area)
    {
        $http.delete('/admin/api/v1/widget/area/' + area.id).success(function(data)
        {
           area.refresh();
        });
    }

    area.syncInstances = function(areaId, instances)
    {
        $http.put('/admin/api/v1/widget/area/' + areaId + '/instances', {instances: instances}).success(function(data)
        {
           area.refresh();
        });
    }

    area.removeInstance = function(instance, areaModel)
    {
        var areaIndex = $scope.areas.indexOf(areaModel);
        var instanceIndex = $scope.areas[areaIndex].widget_instances.indexOf(instance);


        $scope.areas[areaIndex].widget_instances.splice(instanceIndex, 1);

    }

    area.refresh = function()
    {
        this.getAll();
    }

	return area;
});