angular.module('admin').factory('Module', function ($http) {
    var module = {};

    module.modules = [];

    module.getAll = function () {
        $http.get('/admin/api/v1/modules').success(function (data) {
            module.modules = data.modules;
        });
    }

    module.install = function (id) {
        $http.get('/admin/api/v1/module/' + id + '/install').success(function (data) {
            console.log(data);
        });
    }

    return module;
});