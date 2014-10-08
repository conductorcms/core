<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>Fortify Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/packages/mattnmoore/conductor/assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>

     <body class="skin-blue">

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
	             <div class="navbar-right">
	                 <ul class="nav navbar-nav">


	                     <!-- User Account: style can be found in dropdown.less -->
	                     <li class="dropdown user user-menu">
	                         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                             <i class="glyphicon glyphicon-user"></i>
	                             <span>Admin <i class="caret"></i></span>
	                         </a>
	                         <ul class="dropdown-menu">

	                             <li class="user-footer">
	                                 <div class="pull-right">
	                                     <a href="#" class="btn btn-default btn-flat">Sign out</a>
	                                 </div>
	                             </li>
	                         </ul>
	                     </li>
	                 </ul>
	             </div>
	         </nav>
	     </header>
	     <div class="wrapper row-offcanvas row-offcanvas-left">
	         <!-- Left side column. contains the logo and sidebar -->
	         <aside class="left-side sidebar-offcanvas">
	             <!-- sidebar: style can be found in sidebar.less -->
	             <section class="sidebar">
	                 <!-- /.search form -->
	                 <!-- sidebar menu: : style can be found in sidebar.less -->
	                 <ul class="sidebar-menu">
	                     <li class="treeview">
	                         <a href="#">
	                             <i class="fa fa-list-alt"></i>
	                             <span>Programs</span>
	                             <i class="fa fa-angle-left pull-right"></i>
	                         </a>
	                         <ul class="treeview-menu">
	                             <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Videos</a></li>
	                             <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Inventories</a></li>
	                             <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Variables</a></li>
	                         </ul>
	                     </li>
	                     <li>
	                         <a href="pages/calendar.html">
	                             <i class="fa fa-puzzle-piece"></i> <span>Modules</span>
	                             <small class="badge pull-right bg-red">3</small>
	                         </a>
	                     </li>
	                 </ul>
	             </section>
	             <!-- /.sidebar -->
	         </aside>

        @yield('content')

         <!-- jQuery 2.0.2 -->
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
         <!-- Bootstrap -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
         <!-- AdminLTE App -->
         <script src="/packages/mattnmoore/conductor/assets/js/AdminLTE/app.js" type="text/javascript"></script>

     </body>
 </html>