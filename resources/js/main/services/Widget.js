angular.module('admin').factory('Widget', function ($http) {
	var widget = {};

	widget.widgets = [];

	widget.getAll = function()
	{
		return $http.get('/admin/api/v1/widgets').success(function(data)
		{
			angular.copy(data.widgets, widget.widgets);
		});
	}

    widget.getOptions = function(widget)
    {
        return $http.get('/admin/api/v1/widget/' + widget.id + '/options');
    }

	return widget;
});