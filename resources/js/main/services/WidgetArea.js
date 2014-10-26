angular.module('admin').factory('WidgetArea', function ($http) {
	var area = {};

	area.areas = [];

	area.getAll = function()
	{
		$http.get('/admin/api/v1/widget/areas').success(function(data)
		{
			angular.copy(data.areas, area.areas);
		});
	}

	return area;
});