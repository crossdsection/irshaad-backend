<?php

if(isset($_GET['email']))
{
	
	?>
	<input type="hidden" value="<?=$_GET['email']?>" name="verifyEmail">
	<?php
}
else
{
	header("location:../view");
}
?>
<html>
<head>
<title>Verify Email</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<style>
.wrapper {    
	margin-top: 80px;
	margin-bottom: 20px;
}

.form-signin {
  max-width: 420px;
  padding: 30px 38px 66px;
  margin: 0 auto;
  background-color: #eee;
  border: 3px dotted rgba(0,0,0,0.1);  
  }

.form-signin-heading {
  text-align:center;
  margin-bottom: 30px;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
}

input[type="text"] {
  margin-bottom: 0px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.colorgraph {
  height: 7px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}
</style>

</head>
<body>

<!------ Include the above in your HEAD tag ---------->

<div class = "container">
	<div class="wrapper">
		<form action="javascript:void(0)" method="post" name="Login_Form" class="form-signin verifyEmail">       
		    <h3 class="form-signin-heading">Welcome to World Voting</h3>
			  <hr class="colorgraph"><br>
			  
			  <input type="text" class="form-control" name="email" value="<?=$_GET['email']?>" disabled=disabled >
			  <input type="password" class="form-control" name="password" placeholder="Enter Password" required=""/>     		  
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Verify Email</button>  			
		</form>			
	</div>
</div>
<script>
 $(document).on("submit",".verifyEmail", function(event){
	  var email = $(this).find("input[name='email']").val();
	  var password = $(this).find("input[name='password']").val();
	  if(password.length == 0)
	  {
		  alert("Password should be mandatory");
		  return;
	  }
	  var formData = new FormData($(this) [0]);
	  
	 $.ajax({
		       type:"post",
			   url:"../controller/UserController.php?action=verifySubAdminEmail",
			   data: {email: email, password: password},
			   success: function(response){
				   response = JSON.parse(response);
				   if(response.status == 0)
				   {
					   swal(response.message);
				   }
				   else
				   {
					   swal(response.message);
				   }
			    }
	        }); 
 });
</script>

</body>
</html>