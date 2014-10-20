angular.module('admin.core').provider('Navigation', function() {
    var _navigation = [];

    this.$get = function() {
        return {
            getNav: function() {
                return _navigation;
            }
        }
    }

    this.addSection = function(section) {
        _navigation.push(section);
    }

    this.setupModuleNavigation = function(module, route)
    {
        var nav = {
            title: module.title,
            items: []
        };

        for(var ii in module.items)
        {
            var item = module.items[ii];

            route.when(item.uri, {
                templateUrl: item.template,
                controller: item.controller,
                permissions: item.permissions
            });

            nav.items.push({title: item.title, link: item.uri});
        }

        this.addSection(nav);
    }

});