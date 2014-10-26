angular.module('admin').controller('WidgetAreasCtrl', function ($scope, WidgetArea) {

	$scope.areas = WidgetArea.areas;

	WidgetArea.getAll();

});