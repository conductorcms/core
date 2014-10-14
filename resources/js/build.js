angular.module("admin.core", []);
var dependencies = ["admin.core", "ngRoute", "ui.bootstrap"];
for (var ii in window.modules)dependencies.push(window.modules[ii]);
angular.module("admin", dependencies).config(["$routeProvider", "$locationProvider", "$interpolateProvider", "NavigationProvider", function (e, t, n, o) {
    e.when("/admin", {
        templateUrl: "/packages/mattnmoore/conductor/assets/views/index.html",
        controller: "HomeCtrl"
    }), t.html5Mode(!0), n.startSymbol("<%"), n.endSymbol("%>"), o.addSection({
        title: "Core",
        items: [{title: "Home", link: "/admin"}]
    })
}]), angular.module("admin.core").provider("Navigation", function () {
    var e = [];
    this.$get = function () {
        return {
            getNav: function () {
                return e
            }
        }
    }, this.addSection = function (t) {
        e.push(t)
    }
}), angular.module("admin").controller("HomeCtrl", ["$scope", function () {
}]), angular.module("admin").controller("NavCtrl", ["$scope", "Navigation", function (e, t) {
    this.menu = t.getNav(), console.log(this.menu)
}]), angular.module("admin.battletracker", ["ngRoute", "admin.core"]).config(["$routeProvider", "NavigationProvider", function (e, t) {
    e.when("/admin/battletracker", {
        templateUrl: "/packages/mattnmoore/conductor/assets/views/battletracler/index.html",
        controller: "BattletrackerCtrl"
    }), t.addSection({title: "Battletracker", items: [{title: "Overview", link: "/admin/battletracker"}]})
}]);