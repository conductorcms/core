angular.module('admin.core').provider('Navigation', function() {
    var _navigation = {};

    this.$get = function() {
        return {
            getNav: function() {
                return _navigation;
            }
        }
    }

    this.addItem = function(section, title, uri) {
        console.log('Adding: ' + section + ', ' + title);
        if(!_navigation[section])
        {
            _navigation[section] = [];
        }
        _navigation[section].push({ title: title, uri: uri });
    }

    this.addItemsFromArray = function(items) {
        for(var ii in items) {
            this.addItem(items[ii].section, items[ii].title, items[ii].uri);
        }
    }
});