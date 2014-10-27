angular.module('admin').controller('WidgetAreasCtrl', function ($scope, WidgetArea) {

	$scope.areas = WidgetArea.areas;

	WidgetArea.getAll();

    $scope.addArea = function()
    {
        var area = {
            name: '',
            slug: '',
            newArea: true
        };

        $scope.areas.push(area)
    }

    $scope.saveArea = function(area)
    {
        WidgetArea.save(area);
    }

    $scope.deleteArea = function(area)
    {
        $scope.areas.splice($scope.areas.indexOf(area), 1);
        if(!area.newArea)
        {
            WidgetArea.deleteArea(area);
        }
    }

});