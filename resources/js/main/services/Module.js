angular.module('admin').factory('Module', function ($http, $rootScope) {
    var module = {};

    module.modules = [];

    module.getAll = function()
    {
        return $http.get('/admin/api/v1/modules').success(function(data)
        {
            angular.copy(data.modules, module.modules);
        });
    }

    module.install = function(id)
    {
        return $http.get('/admin/api/v1/module/' + id + '/install').success(function(data)
        {

        });
    }

    module.uninstall = function(id)
    {
        return $http.get('/admin/api/v1/module/' + id + '/uninstall').success(function(data)
        {

        });
    }

    module.updateModule = function(id, module)
    {
        for(var ii in this.modules)
        {
            if(this.modules[ii].id == id)
            {
                angular.copy(module, this.modules[ii]);
            }
        }
    }

    return module;
});