angular.module('admin').controller('ModulesCtrl', function ($scope, Module, toaster) {

    $scope.modules = Module.modules;

    $scope.install = function(module)
    {
        module.installing = true;

        Module.install(module.id).success(function(data)
        {
            module.installing = false;
            toaster.pop('success', 'Module installed!', 'The ' + module.display_name + ' module was successfully installed');
            location.reload();
        });
    }

    $scope.uninstall = function(module)
    {
        module.uninstalling = true;
        Module.uninstall(module.id).success(function()
        {
            module.uninstalling = false;
            toaster.pop('error', 'Module uninstalled!', 'The ' + module.display_name + ' module was sucessfully uninstalled');
            location.reload();
        });
    }

});