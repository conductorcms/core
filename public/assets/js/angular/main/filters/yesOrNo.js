angular.module('admin').filter('yesOrNo', function()
{
	return function(input)
	{
		return input ? 'Yes' : 'No';
	}
});