angular.module("admin.pages.templates", []).run(["$templateCache", function($templateCache) {$templateCache.put("pages/pages/create.html","<!-- Main content -->\r\n<section class=\"content\">\r\n	<div class=\"row\">\r\n		<!-- left column -->\r\n		<div class=\"col-md-10 col-md-offset-1\">\r\n			<!-- general form elements -->\r\n			<div class=\"box box-primary\">\r\n				<div class=\"box-header\">\r\n					<h3 class=\"box-title\">Add a page</h3>\r\n				</div><!-- /.box-header -->\r\n\r\n				<!-- form start -->\r\n				<form role=\"form\">\r\n					<div class=\"box-body\">\r\n						<button style=\"margin-bottom: 20px\" class=\"btn btn-primary\">Set Page Type</button>\r\n						<div class=\"form-group\">\r\n							<label for=\"page-name\">Page Name</label>\r\n							<input type=\"text\" class=\"form-control\" id=\"page-name\" placeholder=\"Page Name\">\r\n						</div>\r\n						<div class=\"form-group\">\r\n							<label for=\"page-content\">Page Content</label>\r\n							<div text-angular ng-model=\"htmlVariable\"></div>\r\n						</div>\r\n					</div><!-- /.box-body -->\r\n\r\n					<div class=\"box-footer\">\r\n						<button type=\"submit\" class=\"btn btn-primary\">Submit</button>\r\n					</div>\r\n				</form>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</section>");
$templateCache.put("pages/pages/list.html","<btn class=\"btn btn-primary pull-right\">Add a page</btn><br /><br />\n\n\n\n<table class=\"table table-hover\">\n    <thead>\n    <tr>\n        <th>Name</th>\n        <th>Page Type</th>\n        <th>Status</th>\n        <th></th>\n    </tr>\n    </thead>\n    <tbody>\n    <tr >\n        <td>Pricing</td>\n        <td>Pricing</td>\n        <td>Published</td>\n        <td>\n            <button class=\"btn btn-warning\">Edit</button>\n            <button class=\"btn btn-danger\">Delete</button>\n        </td>\n    </tr>\n    </tbody>\n</table>");
$templateCache.put("pages/types/create.html","\r\n\r\n<!-- Main content -->\r\n<section class=\"content\">\r\n	<div class=\"row\">\r\n		<!-- left column -->\r\n		<div class=\"col-md-10 col-md-offset-1\">\r\n			<!-- general form elements -->\r\n			<div class=\"box box-primary\">\r\n				<div class=\"box-header\">\r\n					<h3 class=\"box-title\">Add a page type</h3>\r\n				</div><!-- /.box-header -->\r\n\r\n				<!-- form start -->\r\n				<form role=\"form\">\r\n					<div class=\"box-body\">\r\n						<div class=\"form-group\">\r\n							<label for=\"page-name\">Page Type Name</label>\r\n							<input ng-model=\"type.name\" type=\"text\" class=\"form-control\" id=\"page-name\" placeholder=\"Page Name\">\r\n						</div>\r\n						<div class=\"form-group\">\r\n							<label for=\"page-layout\">Layout</label>\r\n							<select ng-model=\"type.layout\" class=\"form-control\" ng-options=\"layout.slug as layout.filename for layout in pageLayouts\">\r\n								<option>Select a layout</option>\r\n							</select>\r\n						</div>\r\n						<button ng-click=\"addContentArea()\" class=\"btn btn-primary\">Add a content area</button>\r\n					</div><!-- /.box-body -->\r\n					<div class=\"box-footer\">\r\n					</div>\r\n				</form>\r\n			</div>\r\n\r\n			<div ng-repeat=\"area in contentAreas\" class=\"box box-warning\">\r\n				<form role=\"form\">\r\n					<div class=\"box-body\">\r\n						<button ng-click=\"removeContentArea(area)\" class=\"btn btn-danger btn-sm pull-right\" style=\"margin-bottom: 20px\">Delete</button>\r\n						<div class=\"form-group\">\r\n							<label for=\"content-area-name\">Content Area Name</label>\r\n							<input ng-model=\"area.name\" type=\"text\" class=\"form-control\" id=\"content-area-name\" placeholder=\"Page Name\">\r\n							<input ng-model=\"area.slug\" type=\"text\" class=\"form-control\" disabled value=\"slug\">\r\n						</div>\r\n						<div class=\"form-group\">\r\n							<label for=\"page-layout\">Type</label>\r\n							<select ng-model=\"area.type\" class=\"form-control\">\r\n								<option>Input</option>\r\n								<option>Textarea</option>\r\n								<option>Wysiwyg</option>\r\n								<option>Select</option>\r\n							</select>\r\n						</div>\r\n					</div><!-- /.box-body -->\r\n					<div class=\"box-footer\">\r\n					</div>\r\n				</form>\r\n\r\n		</div>\r\n	</div>\r\n</section>");
$templateCache.put("pages/types/list.html","<a href=\"/admin/pages/types/create\" class=\"btn btn-primary pull-right\">Add a type</a><br /><br />\n\n<table class=\"table table-hover\">\n    <thead>\n    <tr>\n        <th>Name</th>\n        <th>Content Areas</th>\n        <th></th>\n    </tr>\n    </thead>\n    <tbody>\n    <tr >\n        <td>Pricing</td>\n        <td>3</td>\n        <td>\n            <button class=\"btn btn-warning\">Edit</button>\n            <button class=\"btn btn-danger\">Delete</button>\n        </td>\n    </tr>\n    </tbody>\n</table>");}]);