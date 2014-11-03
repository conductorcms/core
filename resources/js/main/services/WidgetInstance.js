angular.module('admin').factory('WidgetInstance', function ($http) {
    var instance = {};

    instance.instances = [];

    instance.getAll = function()
    {
        return $http.get('/admin/api/v1/widget/instances').success(function(data)
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

    instance.find = function(id)
    {
        return $http.get('/admin/api/v1/widget/instance/' + id);
    }

    instance.destroy = function(id)
    {
        return $http.delete('/admin/api/v1/widget/instance/' + id).success(function(data)
        {
            instance.getAll();
        });
    }

    return instance;
});