angular.module('admin').controller('NavCtrl', function ($scope, Navigation) {
    this.menu = Navigation.getNav();
});