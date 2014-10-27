angular.module('admin').factory('WidgetArea', function ($http) {
	var area = {};

	area.areas = [];

	area.getAll = function()
	{
		$http.get('/admin/api/v1/widget/areas').success(function(data)
		{
            for(var ii in data.areas)
            {
                data.areas[ii].instances = [];
            }

			angular.copy(data.areas, area.areas);
		});
	}

    area.save = function(properties)
    {
        $http({
            method: 'POST',
            url: '/admin/api/v1/widget/areas',
            data: properties
        }).success(function(data)
        {
            area.refresh();
        });
    }

    area.deleteArea = function(area)
    {
        $http.delete('/admin/api/v1/widget/area' + area.id).success(function(data)
        {
           area.refresh();
        });
    }

    area.refresh = function()
    {
        this.getAll();
    }

	return area;
});