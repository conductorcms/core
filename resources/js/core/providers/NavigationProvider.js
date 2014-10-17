angular.module('admin.core').provider('Navigation', function() {
    var _navigation = [];

    this.$get = function () {
        return {
            getNav: function () {
                return _navigation;
            }
        }
    }

    this.addSection = function (section) {
        _navigation.push(section);
    }
})