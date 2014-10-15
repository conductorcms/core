angular.module('admin').filter('yesOrNo', function () {
    return function (input) {
        return input == 1 ? 'Yes' : 'No';
    }
});