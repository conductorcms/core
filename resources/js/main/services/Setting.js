angular.module('admin').factory('Setting', function ($http) {

    var setting = {};

    setting.settings = {};

    setting.getAll = function()
    {
        return $http.get('/admin/api/v1/settings').success(function(data)
        {
            angular.copy(data, setting.settings);
        });
    }

    setting.save = function(settings)
    {
        return $http.post('/admin/api/v1/settings/batch', {settings: settings}).success(function(data)
        {
           setting.getAll();
        });
    }

    return setting;
});