<?php
   include_once('../controller/SessionController.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>World Voting - Admin Panel</title>

        <!-- Bootstrap Core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="assets/css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
      <style>
        .admin-class-anchor {
          margin-left:145px;
          font-size:16px;
        }

        .admin-class-anchor:hover {
          text-decoration:none;
        }
      </style>
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Login</h3>
              </div>
              <div class="panel-body">
                <form role="form" class="admin-login" method="post">
                  <fieldset>
                    <div class="form-group">
                      <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                    </div>
                    <div class="form-group">
                      <input class="form-control" placeholder="Password" name="password" type="password" value="">
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="authority_role">
                        <option value="00">Select Role</option>
                        <option value="0">Admin</option>
                        <option value="1">Subadmin</option>
                      </select>
                    </div>
                    <!--div class="checkbox">
                    <label>
                    <a href="register.php" class="admin-class-anchor">Register as subadmin</a>
                    </label>
                    </div-->





                    <!-- Change this to a button or input when using this as a form -->
                    <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                    <!--a href="index.html" class="btn btn-lg btn-success btn-block">Login</a-->
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- jQuery -->
      <script src="assets/js/jquery.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Metis Menu Plugin JavaScript -->
      <script src="assets/js/metisMenu.min.js"></script>
      <!-- Custom Theme JavaScript -->
      <script src="assets/js/startmin.js"></script>
      <script>
	   $(document).on("submit", ".admin-login", function(event){
		   event.preventDefault();
		   var formData = new FormData($(this) [0]);

		   if( validateLoginForm() == true ) {
			   $.ajax({
            url:'../controller/LoginController.php?action=adminOrSubAdminLogin',
            type:'post',
            data:formData,
            processData: false,
            contentType: false,
            success:function(response) {
              response = JSON.parse(response);
              if(response.status == 1) {
                window.location.href = 'home.php';
              } else {
                alert(response.message);
              }
            }
			   });
		   }
	   });


	   function validateLoginForm() {
        var email = $('.admin-login').find('input[name="email"]').val();
        if( email == '' ) {
         alert("Email is required.");
         return false;
        }
        var password = $('.admin-login').find('input[name="password"]').val();
        if( password == '' ) {
         alert("Password is required.");
         return false;
        }
        var role = $('.admin-login').find('select[name="authority_role"]').val();
        if( role == '00' ) {
         alert("Select role.");
         return false;
        }
        return true;
	   }
	 </script>
    </body>
</html>
