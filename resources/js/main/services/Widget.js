angular.module('admin').factory('Widget', function ($http) {
	var widget = {};

	widget.widgets = [];

	widget.getAll = function()
	{
		$http.get('/admin/api/v1/widgets').success(function(data)
		{
			angular.copy(data.widgets, widget.widgets);
		});
	}

	return widget;
});