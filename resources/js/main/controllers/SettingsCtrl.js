angular.module('admin').controller('SettingsCtrl', function ($scope, Setting, toaster) {

    $scope.settings = Setting.settings;

    $scope.save = function()
    {
        var settings = objectToArray($scope.settings);

        Setting.save(settings).success(function()
        {
            toaster.pop('success', 'Settings updated!', 'Your changes were successfully saved');
        });
    }

    function objectToArray(object)
    {
        var array = [];
        for(var ii in object)
        {
            array.push(object[ii]);
        }

        return array.reduce(function(a, b)
        {
            return a.concat(b);
        });
    }
});