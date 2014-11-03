angular.module('admin').controller('WidgetListCtrl', function ($scope, Widget) {

	$scope.widgets = Widget.widgets;

});