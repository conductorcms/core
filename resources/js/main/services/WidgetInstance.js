angular.module('admin').factory('WidgetInstance', function ($http) {
    var instance = {};

    instance.instances = [];

    instance.getAll = function()
    {
        $http.get('/admin/api/v1/widget/instances').success(function(data)
        {
            angular.copy(data.instances, instance.instances);
        });
    }

    instance.save = function(widget, data)
    {
        $http.post('/admin/api/v1/widget/' + widget.id + '/instance', data).success(function(data)
        {
           instance.getAll();
        });
    }

    return instance;
});