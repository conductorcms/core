angular.module('admin').controller('SettingsCtrl', function ($scope, Setting) {

    $scope.settings = Setting.settings;

    Setting.getAll();
});