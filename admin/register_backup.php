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
                            <form role="form">
                                <fieldset>
								    <div class="form-group">
                                        <input class="form-control" placeholder="First Name" name="firstName" type="text" autofocus>
                                    </div>
									<div class="form-group">
                                        <input class="form-control" placeholder="Last Name" name="lasttName" type="text" autofocus>
                                    </div>
									<div class="form-group">
                                        <input class="form-control" placeholder="Mobile Number" name="mobileNumber" type="text" autofocus>
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
									<!--div class="form-group">
									    <select class="form-control subadmin-level" name="su">
										    <option value="00">Select Subadmin as</option>
											<option value="0">World voting subadmin</option>
											<option value="1">Department subadmin</option>
											<option value="2">Media subadmin</option>
											<option value="3">RWA subadmin</option>
										</select>
									</div-->
									
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
									<!--div id="show-county-data">
										<div class="form-group">
											 <select class="form-control country-data" name="country">
											   <option value="00">Select Country</option>
											   <option value="0">Country Name</option>
											</select>
										</div>
									</div>
                                    <div id="show-state-data">									
										<div class="form-group">
											<select class="form-control state-data" name="state">
											   <option value="00">Select State</option>
											   <option value="0">State Name</option>
											</select>
										</div>
									</div>
                                    <div id="department-name">									
										<div class="form-group">
											<select class="form-control" name="department-name">
												   <option value="00">Select Department</option>
												   <option value="0">Department Name</option>
											</select>
										</div>
									</div>
									  
							
							
                                    <!-- Change this to a button or input when using this as a form -->
                                    <a href="#" class="btn btn-lg btn-success btn-block">Register</a>
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
					//console.log(response);
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
