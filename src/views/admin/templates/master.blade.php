<!DOCTYPE html>
<html>
    <head>
		<base href="/">
        <meta charset="UTF-8">
        <title>Fortify Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/conductor/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="/conductor/admin/css/toaster.css" rel="stylesheet" type="text/css" />
        <link href="/conductor/admin/css/admin.css" rel="stylesheet" type="text/css" />


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        @include('conductor::admin.partials.registerModules')

		<!-- temporary -->
		<!-- ui-bootstrap style -->
		<style>
			.nav, .pagination, .carousel, .panel-title a { cursor: pointer; }
		</style>

    </head>

     <body ng-app="admin" class="skin-blue">
        <toaster-container toaster-options="{'position-class': 'toast-bottom-right'}"></toaster-container>

         <!-- header logo: style can be found in header.less -->
	     <header class="header">
	         <a href="index.html" class="logo">
	             <!-- Add the class icon to your logo image or logo icon to add the margining -->
	             Fortify
	         </a>
	         <!-- Header Navbar: style can be found in header.less -->
	         <nav class="navbar navbar-static-top" role="navigation">
	             <!-- Sidebar toggle button-->
	             <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
	                 <span class="sr-only">Toggle navigation</span>
	                 <span class="icon-bar"></span>
	                 <span class="icon-bar"></span>
	                 <span class="icon-bar"></span>
	             </a>
	             <div ng-controller="SessionCtrl" class="navbar-right">
	                 <ul class="nav navbar-nav">
	                     <!-- User Account: style can be found in dropdown.less -->
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
	         <!-- Left side column. contains the logo and sidebar -->
	         <aside class="left-side sidebar-offcanvas">
	             <!-- sidebar: style can be found in sidebar.less -->
	             <section class="sidebar">

	                <accordion close-others="false">
                        <accordion-group ng-repeat="section in nav.menu" heading="<% section.title %>">
                            <ul>
                                <li ng-repeat="item in section.items"><a href="<% item.link %>"><% item.title %></a></li>
                            </ul>
                        </accordion-group>
                    </accordion>

	             </section>
	             <!-- /.sidebar -->
	         </aside>

	           <!-- Right side column. Contains the navbar and content of the page -->
             <aside class="right-side">
                 <!-- Content Header (Page header) -->
                 <section class="content-header">
                     <h1>
                         Home
                         <small>Control panel</small>
                     </h1>
                     <ol class="breadcrumb">
                         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                         <li class="active">Modules</li>
                     </ol>
                 </section>


        @yield('content')


         <!-- Dependencies -->
         <script src="/conductor/admin/js/dependencies.js"></script>

         <!-- Mah app -->
         <script src="/conductor/admin/js/conductor.js"></script>

         <!-- jQuery 2.0.2 -->
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
         <!-- Bootstrap -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


     </body>
 </html>