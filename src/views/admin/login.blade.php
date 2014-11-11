<!DOCTYPE html>
<html class="bg-black">
    <head>
       <meta charset="UTF-8">
       <title>Conductor Admin | Log in</title>
       <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
       <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
       <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
       <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />

       <link href="/conductor/backend/css/dependencies.css" rel="stylesheet" type="text/css" />

    </head>
    <body ng-app="admin" class="bg-black">

        <div ng-controller="LoginCtrl" class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form>
                <div class="body bg-gray">
                    <div class="form-group">
                        <input ng-model="user.email" type="text" name="email" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <input ng-model="user.password" type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input ng-model="user.remember" type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">
                    <button ng-click="login()" ng-hide="loggingIn" type="submit" class="btn bg-olive btn-block">Sign me in</button>
                    <button ng-click="login()" ng-show="loggingIn" type="submit" class="btn bg-olive btn-block" disabled>
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>

                    <p><a href="#">I forgot my password</a></p>
                </div>
            </form>


        </div>

        <!-- Angular, son! -->
        <script src="/conductor/backend/js/dependencies.min.js"></script>
         <!-- Mah app -->
         <script src="/conductor/backend/js/conductor.min.js"></script>
         <!-- jQuery 2.0.2 -->
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
         <!-- Bootstrap -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>