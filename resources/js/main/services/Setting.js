angular.module('admin').factory('Setting', function ($http) {

    var setting = {};

    setting.settings = {};

    setting.getAll = function()
    {
        $http.get('/admin/api/v1/settings').success(function(data)
        {
            angular.copy(data, setting.settings);
            console.log(setting.settings);
        });
    }

    return setting;
});