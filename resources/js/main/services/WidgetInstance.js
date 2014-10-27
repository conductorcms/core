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

    return instance;
});