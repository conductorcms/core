<!DOCTYPE html>
<html>
    <head>
		<base href="/">
        <meta charset="UTF-8">
        <title>Conductor Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/conductor/admin/css/dependencies.css" rel="stylesheet" type="text/css" />
        <link href="/conductor/admin/css/admin.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        @include('core::admin.partials.registerModules')

		<!-- temporary -->
		<!-- ui-bootstrap style -->
		<style>
			.nav, .pagination, .carousel, .panel-title a { cursor: pointer; }
		</style>

    </head>

     <body ng-app="admin" class="skin-blue">
         <toaster-container toaster-options="{'position-class': 'toast-bottom-right'}"></toaster-container>

	     <header class="header">
	         <div class="pull-left" ng-controller="RouteLoadingCtrl" style="background-color: #367fa9; padding: 9px">
	              <div ng-hide="loading" style="padding: 16px"></div>
                  <img ng-show="loading" height="32" width="32" src="/conductor/admin/img/admin-loader.GIF" />
	         </div>
	         <a href="index.html" class="logo" style="width: 171px !important; padding-left: 22px; text-align: left;">
	             Conductor
	         </a>
	         <nav class="navbar navbar-static-top" role="navigation">
	             <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
	                 <span class="sr-only">Toggle navigation</span>
	                 <span class="icon-bar"></span>
	                 <span class="icon-bar"></span>
	                 <span class="icon-bar"></span>
	             </a>
	             <div ng-controller="SessionCtrl" class="navbar-right">
	                 <ul class="nav navbar-nav">
	                     <li class="dropdown user user-menu">
	                         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                             <i class="glyphicon glyphicon-user"></i>
	                             <span><% session.user.email %> <i class="caret"></i></span>
	                         </a>
	                         <ul class="dropdown-menu">

	                             <li class="user-footer">
	                                 <div class="pull-right">
	                                     <a href="#" ng-click="logout()" class="btn btn-default btn-flat">Sign out</a>
	                                 </div>
	                             </li>
	                         </ul>
	                     </li>
	                 </ul>
	             </div>
	         </nav>
	     </header>
	     <div ng-controller="NavCtrl as nav" class="wrapper row-offcanvas row-offcanvas-left">
	         <aside class="left-side sidebar-offcanvas">
	              <section class="sidebar">
	                <accordion close-others="false" >

                        <accordion-group ng-repeat="(key, value) in nav.menu" is-open="true" heading="<% key %>">
                            <ul>
                                <li ng-repeat="item in value"><a href="<% item.uri %>"><% item.title %></a></li>
                            </ul>
                        </accordion-group>

                    </accordion>
	             </section>

	         </aside>

             <aside class="right-side">
                 @yield('content')
			 </aside>

         <!-- jQuery 2.0.2 -->
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

         <!-- Dependencies -->
         <script src="/conductor/admin/js/dependencies.js"></script>

         <!-- Main app -->
         <script src="/conductor/admin/js/conductor.js"></script>

         <!-- Bootstrap -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

     </body>
 </html>