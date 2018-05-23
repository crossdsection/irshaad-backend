<?php
  require_once('../config/Database.php');
  $db = new Database();
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
       <style>
	   .admin-class-anchor
	   {
		 margin-left:145px;
         font-size:16px;		 
	   }
	   
	   .admin-class-anchor:hover
	   {
		   text-decoration:none;
	   }
	   
	   #show-county-data, #show-state-data, #department-name, #authority_depart_data
	   {
		   display:none;
	   }
	   
	   .hideicon
	   {
		   
          input[type=number]::-webkit-inner-spin-button, 
          input[type=number]::-webkit-outer-spin-button 
		  { 
			  -webkit-appearance: none !important; 
			   margin: 0 !important; 
          }
	   }
	   </style>
	   
	   <?php
	       if((isset($_GET['data'])) && ($_GET['data'] != ''))
		   {
			 $url_address = urldecode($_GET['data']);  
		   }
	       else
		   {
			   header('Location:../index.php');
		   }
	   ?>
	   
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading" style="padding: 15px 5px;">
                            <h3 class="panel-title">Register as <?=$url_address?></h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="javascript:void(0)" class="subadminsignup" enctype="multipart/form-data">
                                <fieldset>
								    <div class="form-group">
                                        <input class="form-control" placeholder="First Name" name="firstName" type="text" autofocus>
                                    </div>
									<div class="form-group">
                                        <input class="form-control" placeholder="Last Name" name="lastName" type="text" autofocus>
                                    </div>
									<div class="form-group">
                                        <input class="form-control hideicon" placeholder="Mobile Number" name="mobileNumber" type="number" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
									<?php
									  if($url_address == 'Media subadmin')
									  {
									
									?>
									<div class="form-group">
									    <input type="text" class="form-control" placeholder="Company Name" name="company_name">
									</div>
									<?php
									  }
									  if($url_address == 'RWA subadmin')
									  {
									?>
									<div class="form-group">
									    <input type="text" class="form-control" placeholder="RWA Name" name="rwa_name">
									</div>
									<?php
									  }
									?>
									<?php
									  if($url_address == 'Government department subadmin')
									  {
									?>
									<div class="form-group">
									   <select class="form-control authority_depart_level" name="authority_department_level" >
									       <option value="00">Select Level</option>
										   <option value="0">World Level</option>
										   <option value="1">Country Level</option>
										   <option value="2">State Level</option>
										   <option value="3">City Level</option>
									   </select>
									</div>
									<?php
									 }
									?>
									
									
									<div class="form-group">
									    <?php
										   $getCountry = $db->select("wv_countries.id,wv_countries.name","wv_countries");
										   
										?>
										<select class="form-control subadmin-country" name="country">
											   <option value="00">Select Country</option>
											   <?php
											      foreach($getCountry as $country)
												  {
											   ?>
											   <option value="<?=$country['id']?>"><?=$country['name']?></option>
												<?php
												  }
												?>  
										</select>
									</div>
									<div class="form-group">
										<select class="form-control subadmin-state" name="state">
											   <option value="00">Select State</option>
											   <option value="0">State Country</option>
										</select>
									</div>
									<div class="form-group">
										<select class="form-control subadmin-city" name="city">
											   <option value="00">Select City</option>
											   <option value="0">Select State</option>
										</select>
									</div>
									
									<div class="form-group">
									    <select class="form-control" id="authority_depart_data" name="authority_depart_data">
										    <option value="00">Select Department</option>
                                        </select>										
									</div>
									<?php
									   if($url_address != 'World voting subadmin')
									   {
									?>
							        <div class="form-group">
									    <label>Upload Certificate</label>
										<input type="file" class="form-control" id="authority_position_certificate" name="authority_position_certificate" title="Upload certificate regarding position">
									</div>
							        <?php 
									   }
									?>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Register</button>
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
		
		      var flag, countryid, stateid, cityid;
		      $(document).on("click",".authority_depart_level", function(){
				
				var department = $(this).val();
				if(department == '00')
				{
					$('#authority_depart_data').hide();
					return;
				}
				else
				{
					
					if(department == '0')
					{
						flag = 0;
                        countryid = 0;
						stateid = 0;
						cityid = 0;
						
						$('.subadmin-country').hide();
						$('.subadmin-state').hide();
						$('.subadmin-city').hide();
						$('#authority_depart_data').show();
						
						getDepartment(flag,countryid,stateid,cityid);
					}
					else if(department == '1')
					{
						flag = 1;
						
						$('.subadmin-country').show();
						$('.subadmin-state').hide();
						$('.subadmin-city').hide();
						$('#authority_depart_data').show();
						$('.subadmin-country').attr('id', 'subadmin-country-dept');
						
						
					}
					else if(department == '2')
					{
						flag =2;
						
						$('.subadmin-country').show();
						$('.subadmin-state').show();
						$('.subadmin-city').hide();
						$('#authority_depart_data').show();
						
						$('.subadmin-country').attr('id', 'subadmin-country-dept');
						$('.subadmin-state').attr('id', 'subadmin-state-dept');
						
						
					}
					else if(department == '3')
					{
						flag = 3;
						
						$('.subadmin-country').show();
						$('.subadmin-state').show();
						$('.subadmin-city').show();
						$('#authority_depart_data').show();
						
						$('.subadmin-country').attr('id', 'subadmin-country-dept');
						$('.subadmin-state').attr('id', 'subadmin-state-dept');
						$('.subadmin-city').attr('id', 'subadmin-city-dept');
						
						
					}
					else
					{
						$('#authority_depart_data').hide();
					}
					
					$('.subadmin-country').prop('selectedIndex',0);
				    $('.subadmin-state').prop('selectedIndex',0);
				    $('.subadmin-city').prop('selectedIndex',0);
				}
			});
			
		$(document).on("submit",".subadminsignup", function(event){
			event.preventDefault();
			
			
			var type_flag = '';
			var firstName = $(this).find("input[name='firstName']").val();
			var lastName = $(this).find("input[name='lastName']").val();
			var mobileNumber = $(this).find("input[name='mobileNumber']").val();
			var email = $(this).find("input[name='email']").val();
			var password = $(this).find("input[name='password']").val();
			var country = $(this).find("select[name='country']").val();
			var state = $(this).find("select[name='state']").val();
			var city = $(this).find("select[name='city']").val();
			
			if(firstName.length == 0)
			{	
				swal("FirstName should be Mandatory");
				return;
			}
			if(lastName.length == 0)
			{
				swal("LastName should be Mandatory");
				return;
			}
			if(mobileNumber.length == 0)
			{
				swal("Mobile Number should be Mandatory");
				return;
			}
			if(mobileNumber.length != 10)
			{
				swal("Please enter valid Mobile Number");
				return;
			}	
			if(email.length == 0)
			{
				swal("Email should be Mandatory");
				return;
				
			}
			if(password.length == 0)
			{
				swal("Password should be ,Mandatory");
				return;
			}
			if(country.length == 0)
			{
				swal("Select Country");
				return;
			}
			if(state.length == 0)
			{
				swal("Select State");
				return;
				
			}
			if(city.length == 0)
			{
				swal("Select City");
				return;
			}
			
			if('<?=$url_address?>' === 'World voting subadmin')
			{
				type_flag = 0;
			}
			else if('<?=$url_address?>' === 'Government department subadmin')
			{
				type_flag = 1;
			}
			else if('<?=$url_address?>' === 'Media subadmin')
			{
				type_flag = 2;
			}
			else if('<?=$url_address?>' === 'RWA subadmin')
			{
				type_flag = 3;
			}
			
			
			var formData = new FormData($(this) [0]);
			formData.append('type_flag',type_flag);
			
			/* for (var value of formData.values()) {
               console.log(value); 
			} */
			
			
			$.ajax({
				type:"post",
				url : "../controller/UserController.php?action=subAdminSignup",
				data : formData,
				processData: false,
                contentType: false,
				success : function(response)
				{
					console.log(response);
					/*response = JSON.parse(response);
					if(response.status == 1)
					{
						alert(response.message);
						
					}
					else{
						alert(response.message);
					}*/
				}
				
				
			});
			
			
			
		});
		  /*$(document).on("click",".authority_depart_data", function(){
			  var department = $(this).val();
			   if(department != '00')
			   {
				   if(department == '0')
				   {
					   $("#show-county-data").hide();
					   $("#show-state-data").hide();
					   $("#department-name").show();
					   
				   }
				   else if(department == '1')
				   {
						$("#show-county-data").show(); 
						$("#show-state-data").hide();
						 $("#department-name").show();
										 
				   }
				   else if(department == '2')
				   {
					    $("#show-county-data").show(); 
                        $("#show-state-data").show();
						$("#department-name").show();
					    
				   }
				  
				   else
				   {
					   $("#show-county-data").hide();
					   $("#show-state-data").hide();
					    $("#department-name").hide();
					   
				   }
			   }
		  });*/
		  
		/* $(document).on('click', '#subadmin-country-dept', function(){
				var country_id_val = $(this).val();
				if(country_id_val == '00')
				{
					return;
				}
				else
				{
					countryid = country_id_val;
				}
				
				console.log(countryid);
		  });*/
		  
		  $(document).on("click", ".subadmin-country", function(){
			  
			  var countryattrid = $(this).attr('id');
			  var stateattrid = $('.subadmin-state').attr('id');
			  var cityattrid = $('.subadmin-city').attr('id');
			  var country_data = $(this).val();
			  
			  if(country_data == '00')
			  {
				  return;
			  }
			  else
			  {
				   if((typeof countryattrid !== typeof undefined) && (typeof stateattrid === typeof undefined) && (typeof cityattrid === typeof undefined))
				   { 
					   countryid = country_data;
					   stateid = 0;
                       cityid = 0;
				   }
				   else
				   {
					   countryid = 0;
					   stateid = 0;
                       cityid = 0;
					   
				   }
				  
				  if(flag == 1)
				  {
				     getDepartment(flag,countryid,stateid,cityid);
				  }
				  
				  $(".subadmin-state").html("");
				  $(".subadmin-state").append('<option value="00">Select State</option>');
				  $.ajax({
					     type:'post',
						 url:'../controller/CountryController.php?action=getState',
						 data:{country_id : country_data},
						 success:function(response)
						 {
							response = JSON.parse(response);
							/*console.log(response);
							console.log(response.data.length);*/
							 for(var i=0; i < response.data.length; i++)
						     {
								$(".subadmin-state").append('<option value="'+response.data[i].id+'">'+response.data[i].name+'</option>');
							 }
							
						 }
					  });
			  }
		  });
		  
		  
		  $(document).on("click", ".subadmin-state", function(){
			  var countryattrid = $('.subadmin-country').attr('id');
			  var stateattrid = $(this).attr('id');
			  var cityattrid = $('.subadmin-city').attr('id');
			
			  
			  var state_data = $(this).val();
			  if(state_data == '00')
			  {
				  return;
			  }
			  else
			  {
				  if((typeof countryattrid !== typeof undefined) && (typeof stateattrid !== typeof undefined) && (typeof cityattrid === typeof undefined))
				   { 
					   countryid = $('.subadmin-country').val();
					   stateid = state_data;
                       cityid = 0;
				   }
				   else
				   {
					   countryid = 0;
					   stateid = 0;
                       cityid = 0;
					   
				   }
				   
				   if(flag == 2)
				   {
				     getDepartment(flag,countryid,stateid,cityid);
				   }
				   
				  $(".subadmin-city").html("");
				  $(".subadmin-city").append('<option value="00">Select City</option>');
				  $.ajax({
					     type:'post',
						 url:'../controller/CountryController.php?action=getCity',
						 data:{state_id : state_data},
						 success:function(response)
						 {
							response = JSON.parse(response);
							/*console.log(response);
							console.log(response.data.length);*/
							 for(var i=0; i < response.data.length; i++)
						     {
								$(".subadmin-city").append('<option value="'+response.data[i].id+'">'+response.data[i].name+'</option>');
							 }
							
						 }
					  });
			  }
		  });
		 
		
		$(document).on("click", ".subadmin-city", function(){
			
			  var countryattrid = $('.subadmin-country').attr('id');
			  var stateattrid = $('.subadmin-state').attr('id');
			  var cityattrid = $(this).attr('id');
			  var city_data = $(this).val();
			  
			  if(city_data == '00')
			  {
				  return;
			  }
			  else
			  {
				   if((typeof countryattrid !== typeof undefined) && (typeof stateattrid !== typeof undefined) && (typeof cityattrid !== typeof undefined))
				   { 
					   countryid = $('.subadmin-country').val();
					   stateid = $('.subadmin-state').val();
                       cityid = city_data;
					   
					  
				   }
				   else
				   {
					   countryid = 0;
					   stateid = 0;
                       cityid = 0;
					  
				   }
				   
				   if(flag == 3)
				   {
				      getDepartment(flag,countryid,stateid,cityid);
				   }
			  }
		});
		
		function getDepartment(flag,country,state,city)
		{
			  $("#authority_depart_data").html("");
			  $("#authority_depart_data").append('<option value="00">Select Department</option>');
			$.ajax({
				type:'post',
				url:'../controller/DepartmentController.php?action=getDepartment',
				data:{ministry_flag:flag,country_id:country,state_id:state,city_id:city},
				success:function(response)
				{
					response = JSON.parse(response);
					console.log(response);
					
					if(response.status != 0)
					{
					 // console.log(response.data.length);
					   for(var j=0; j < response.data.length; j++)
					   {
						 $("#authority_depart_data").append('<option value="'+response.data[j].id+'">'+response.data[j].ministry_name+'</option>');
					
						
					   }
					}
					else
					{
						$("#authority_depart_data").append('<option value="0">'+response.message+'</option>');
					}
				}
			});
		}
		
		 $(document).ready(function() {
			 
              if('<?=$url_address?>' == 'Government department subadmin')
			  {
				  $('.subadmin-country').hide();  
				  $('.subadmin-state').hide();  
				  $('.subadmin-city').hide();  
			  }
          
		  });
		</script>
    </body>
</html>
