<?php 
    include"header.php";

	$getProfileData = $db->select("wv_authority.*,wv_countries.name as country_name, wv_states.name as state_name, wv_cities.name as city_name","wv_authority left join wv_countries on wv_authority.country_id = wv_countries.id left join wv_states on wv_authority.state_id = wv_states.id left join wv_cities on wv_authority.city_id = wv_cities.id","wv_authority.id = '{$subadmin->id}'");
	
    if(count($getProfileData) > 0)
	{
		$getProfileData = $getProfileData[0];
	}
	
?>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include"leftsidebar.php";?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profile Setting</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				
                    <div class="row">
					
				        <div class="col-sm-6 col-md-6 col-lg-6">
						  <form  class="save-profile-setting" method="POST">
						  <fieldset>
						      <legend>Personal Details :</legend>
					        <div class="form-group">
							    <label>First Name</label>
								<input type="text" class="form-control" placeholder="First Name" name="firstName" value="<?=$getProfileData['first_name'];?>">
							</div>
							<div class="form-group">
							    <label>Last Name</label>
								<input type="text" class="form-control" placeholder="Last Name" name="lastName" value="<?=$getProfileData['last_name'];?>">
							</div>
							<div class="form-group">
							  <label>Gender</label>
							  <select class="form-control" name="gender">
							     
								 <?php
								    if($getProfileData['gender'] == '')
									{
								 ?>
								 <option value="00">Select Gender</option>
								 <option value="Male">Male</option>
								 <option value="Female">Female</option>
								 <option value="Others">Others</option>
								 <?php
									}
									else if($getProfileData['gender'] == 'Male')
									{
										?>
								 <option value="00">Select Gender</option>
								 <option value="Male" selected>Male</option>
								 <option value="Female">Female</option>
								 <option value="Others">Others</option>	
								<?php	
								   }
								   else if($getProfileData['gender'] == 'Female')
								   {
									   ?>
								  <option value="00">Select Gender</option>
								  <option value="Male">Male</option>
								 <option value="Female" selected>Female</option>
								 <option value="Others">Others</option>	   
							<?php	   
							       }
								   else
								   {
									   ?>
							      <option value="00">Select Gender</option>
								  <option value="Male">Male</option>
								  <option value="Female">Female</option>
								  <option value="Others"  selected>Others</option>	 
							<?php	   }
								 ?>
							  </select>
							</div>
							<div class="form-group">
							   <label>Phone Number</label>
							   <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="<?=$getProfileData['phone'];?>">
							</div>
							
							<div class="form-group">
							   <label>Email</label>
							   <input type="text" class="form-control" placeholder="Email" name="email" value="<?=$getProfileData['email'];?>">
							</div> 
							</fieldset>
							<fieldset>
							   <legend>Address:</legend>
							<?php
							  if($getProfileData['country_id'] != 0)
							  {
								  $getCountyData = $db->select("*","wv_countries","wv_countries.id != '{$getProfileData['country_id']}'");
							  }
							  else
							  {
								  $getCountyData = $db->select("*","wv_countries");
							  }
							 
							?>
							
							<div class="form-group">
							  <label>Country</label>
							  <select class="form-control show-state-data" name="country_data">
							     <option value="00">Select country</option>
								 <?php
								    if($getProfileData['country_id'] != 0)
									{
								 ?>
								    <option value="<?=$getProfileData['country_id']?>" selected><?=$getProfileData['country_name'];?></option>
								 <?php
								    }
									
									foreach($getCountyData as $countryData)
									{
										?>
									<option value="<?=$countryData['id'];?>"><?=$countryData['name'];?></option>	
								<?php	}
								 ?>
							  </select>
							</div>
							
							<div class="form-group">
							   <label>State</label>
							   <select class="form-control show-state" name="state_data">
							      <option value="00">Select state</option>
								  
								  <?php
								    if($getProfileData['state_id'] != 0)
									{
										?>
									<option value="<?=$getProfileData['state_id'];?>" selected><?=$getProfileData['state_name'];?></option>	
							<?php		
							        }
									
								  ?>
							   </select>
							</div>
							
							<div class="form-group">
							   <label>City</label>
							   <select class="form-control show-city" name="city_data">
							      <option value="00">Select city</option>
								  <?php
                                    if($getProfileData['city_id'] != 0) 
                                    {
										?>
								    <option value="<?=$getProfileData['city_id'];?>" selected><?=$getProfileData['city_name'];?></option>		 
                                <?php    
								    }
                                  											
								  ?>
							   </select>
							</div>
							</fieldset>
							<fieldset>
							 <legend>Subadmin Position Details:</legend>  
							<div class="form-group">
								<label>Subadmin as</label>
								<?php
								  if($getProfileData['determine_subadmin_flag'] == 0)
								  {
									  $subadmintype = "Worldvoting Subadmin";
								  }
								  else if($getProfileData['determine_subadmin_flag'] == 1)
								  {
									  $subadmintype = "Government Subadmin";
								  }
								  else if($getProfileData['determine_subadmin_flag'] == 2)
								  {
									  $subadmintype = "Media Subadmin";
								  }
								  else
								  {
									  $subadmintype = "RWA Subadmin";
								  }
								?>
								<input type="text" class="form-control" placeholder="Subadmin as" name="subadmin" value="<?=$subadmintype;?>" disabled>
							</div>
								<?php
							  if($getProfileData['determine_subadmin_flag'] == 1)
							  {
								  if($getProfileData['department_level_flag'] == 0)
								  {
									  $departmentlevel = "World Level";
								  }
								  else if($getProfileData['department_level_flag'] == 1)
								  {
									 $departmentlevel = "Country Level"; 
								  }
								  else if($getProfileData['department_level_flag'] == 2)
								  {
									 $departmentlevel = "State Level"; 
								  }
								  else if($getProfileData['department_level_flag'] == 3)
								  {
									 $departmentlevel = "City Level"; 
								  }
								  ?>
								<div class="form-group">
                                    <label>Department/Ministry Level At</label>								
							        <input type="text" class="form-control" placeholder="Government department at level" name="department_level" value="<?=$departmentlevel;?>" disabled>	
                                </div>
								
								 <?php
								     $getDepartmentData = $db->select("*","wv_ministry","wv_ministry.id='{$getProfileData['department_id']}' ");
									 
									 if(count($getDepartmentData) > 0)
									 {
										 $getDepartmentData = $getDepartmentData[0];
									 }
									
									 $getCountryName = $db->select("wv_countries.name","wv_countries","wv_countries.id = '{$getDepartmentData['country_id']}'"); 
									 
									 $getStateName = $db->select("wv_states.name","wv_states","wv_states.id = '{$getDepartmentData['state_id']}'"); 
									 
									 $getCityName = $db->select("wv_cities.name","wv_cities","wv_cities.id = '{$getDepartmentData['city_id']}'");
									 
									 
									
									if($getProfileData['department_level_flag'] == 1)
									{
										
										
										?>
										<div class="form-group">
										  <label>Country Name</label>
										  <input type="text" class="form-control" placeholder="Country name" name="country_name" value="<?=$getCountryName[0]['name'];?>" disabled>
										</div>
								<?php	
								    }
									else if($getProfileData['department_level_flag'] == 2)
									{
										?>
									  <div class="form-group">
										  <label>Country Name</label>
										  <input type="text" class="form-control" placeholder="Country name" name="country_name" value="<?=$getCountryName[0]['name'];?>" disabled>
									  </div>
                                      <div class="form-group">
									      <label>State Name</label>
										  <input type="text" class="form-control" placeholder="State name" name="state_name" value="<?=$getStateName[0]['name'];?>" disabled>
                                      </div>
                   									  
								<?php	
								    }
									else if($getProfileData['department_level_flag'] == 3)
									{
										?>
									  <div class="form-group">
										  <label>Country Name</label>
										  <input type="text" class="form-control" placeholder="Country name" name="country_name" value="<?=$getCountryName[0]['name'];?>" disabled>
									  </div>
                                      <div class="form-group">
									      <label>State Name</label>
										  <input type="text" class="form-control" placeholder="State name" name="state_name" value="<?=$getStateName[0]['name'];?>" disabled>
                                      </div>
                                      <div class="form-group">
									     <label>City Name</label>
										 <input type="text" class="form-control" placeholder="City Name" name="city_name" value="<?=$getCityName[0]['name'];?>" disabled>
                                      </div>									  
								<?php	}
								 ?>
                                <div class="form-group">
							        <label>Department Name</label>
								    <input type="text" class="form-control" placeholder="Department name" name="department_name" value="<?=$getDepartmentData['ministry_name'];?>" disabled>
							    </div>								
						<?php	  
						       }
							   else if($getProfileData['determine_subadmin_flag'] == 2)
							   {
							?>
							
							
							<div class="form-group">
							   <label>Company Name</label>
							   <input type="text" class="form-control" placeholder="Company name" name="company_name" value="<?=$getProfileData['company_name'];?>" disabled>
							</div>
							<?php  
							   }
							   else if($getProfileData['determine_subadmin_flag'] == 3)
							   {
							?>
							<div class="form-group">
							   <label>RWA Name</label>
							   <input type="text" class="form-control" placeholder="RWA name" name="rwa_name" value="<?=$getProfileData['rwa_name'];?>" disabled>
							</div>
							<?php
							
							   }
							?>
							  <div class="form-group">
							     <label>Designation</label>
								 <input type="text" class="form-control" placeholder="Designation" name="designation" value="<?=$getProfileData['designation'];?>">
							  </div>
							</fieldset>
							
							
							<div class="form-group">
							   <label></label>
							  <button type="submit" class="btn btn-primary btn-md">Save</button>
							</div>
                         </form>							
						</div>
						
				        <div class="col-sm-6 col-md-6 col-lg-6">
						    <?php
							  if($getProfileData['determine_subadmin_flag'] != 0)
							  {
							?>
						   <fieldset>
						        <legend>Certification Details:</legend>
								<div class="form-group">
								    <label>User Certificate</label><br/>
                                    <img src="../assets/images/department/<?=$getProfileData['upload_certificate']?>" width="300px;" height="300px;">									
								</div>
						   </fieldset>
						   <?php
						      }
						   ?>
						   <form action="" method="post" class="changeImageForm" enctype="multipart/form-data">
						   
						    <fieldset>
							 <legend>Profile Pic Details:</legend>
						    <div class="form-group">						
								<label>Profile Pic</label><br/>
								<?php
								  
								   if($getProfileData['determine_subadmin_flag'] == 1)
									{
										if($getDepartmentData['ministry_head_profilepic'] != '')
										{
										?>
									 <img src="../assets/images/department/<?=$getDepartmentData['ministry_head_profilepic'];?>" width="300px;" height="300px;">	
								<?php	}
									else
									  {
										?>
									  <img src="../assets/images/department/no_image_user.png" width="300px;" height="300px;">
								<?php	
								      }
									}
                                    else
                                    {
										if($getProfileData['profile_picture'] != '')
										{
											?>
									<img src="../assets/images/department/<?=$getProfileData['profile_picture'];?>" width="300px;" height="300px;">		
								<?php		}
										else
										{
											?>
									<img src="../assets/images/department/no_image_user.png" width="300px;" height="300px;">	
								<?php		}
                                    }										
								?>
									
							    
							</div>
							<div class="form-group">
							 
							   <input type="file" class="form-control" name="department_head_pic" id="department_head_pic_id">
								<label for="department_head_pic_id" class="btn btn-danger btn-md">Change Image</label>
							</div>
							</fieldset>
						</form> 
							
						
					    </div>	
				    </div>		
			
				
				  
					
                </div>
              
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

      

        <!-- Metis Menu Plugin JavaScript -->
        <script src="assets/js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="assets/js/raphael.min.js"></script>
       
        <!-- Custom Theme JavaScript -->
        <script src="assets/js/startmin.js"></script>
 <!-- DataTables JavaScript -->
        <script src="assets/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.min.js"></script>
		<script>
		    $(document).on("click", ".show-state-data", function(){
			   var country_id = $(this).val();
			   if(country_id == '00')
			   {
				   return;
			   }
			   else
			   {
				    $(".show-state").html("");
				    $(".show-state").append('<option value="00">Select State</option>');
					$.ajax({
					     type:'post',
						 url:'../controller/CountryController.php?action=getState',
						 data:{country_id : country_id},
						 success:function(response)
						 {
							response = JSON.parse(response);
							/*console.log(response);
							console.log(response.data.length);*/
							 for(var i=0; i < response.data.length; i++)
						     {
								$(".show-state").append('<option value="'+response.data[i].id+'">'+response.data[i].name+'</option>');
							 }
							
						 }
					  });
			   }
		   });
		
		   $(document).on("click", ".show-state", function(){
			   var state_id = $(this).val();
			   if(state_id == '00')
			   {
				   //alert("Select country first.");
				   return;
			   }
			   else
			   {
				    $(".show-city").html("");
				    $(".show-city").append('<option value="00">Select City</option>');
				  $.ajax({
					     type:'post',
						 url:'../controller/CountryController.php?action=getCity',
						 data:{state_id : state_id},
						 success:function(response)
						 {
							response = JSON.parse(response);
							/*console.log(response);
							console.log(response.data.length);*/
							 for(var i=0; i < response.data.length; i++)
						     {
								$(".show-city").append('<option value="'+response.data[i].id+'">'+response.data[i].name+'</option>');
							 }
							
						 }
					  });
			   }
		   });
		  
		  $(document).on("click", ".show-city", function(){
			  var city_id = $(this).val();
			  
			  if(city_id == '00')
			  {
				//alert("Select state first.");
                return;				
			  }
		  });
		  
		  
		  
		  $(document).on("submit", ".save-profile-setting", function(event){
			   event.preventDefault();
			   //console.log("HI");
			   var gender = $(this).find('select[name="gender"]').val();
			   if(gender == '00')
			   {
				   alert("Select gender first.");
				   return;
			   }
			   
			   var country_data_address = $(this).find('select[name="country_data"]').val();
			   if(country_data_address == '00')
			   {
				   alert("Select country first.");
				   return;
			   }
			   
			   var state_data_address = $(this).find('select[name="state_data"]').val();
			   if(state_data_address == '00')
			   {
				   alert("Select state first.");
				   return;
			   }
			   
			   
			   var city_data_address = $(this).find('select[name="city_data"]').val();
			   if(city_data_address == '00')
			   {
				   alert("Select city first.");
				   return;
			   }
			   
			   var designation = $(this).find('input[name="designation"]').val();
			   if(designation == '')
			   {
				   alert("Designation can not be empty.");
				   return;
			   }
			   
			   var formData = new FormData($(this) [0]);
			     formData.append('id','<?=$subadmin->id;?>');
			   $.ajax({
				   url:'../controller/UserController.php?action=subadminProfileSetting',
				   type:'post',
				   data:formData,
				   processData: false,
                   contentType: false,
				   success:function(response)
				   {
					   //console.log(response);
					   response = JSON.parse(response);
					   if(response.status == 1)
					   {
						   alert(response.message);
						   location.reload();
					   }
					   else
					   {
						  alert(response.message); 
					   }	   
				   }
				   
			   });
			   
		  });
		  
		  
		   $("#department_head_pic_id").change(function(){
			   $(".changeImageForm").submit();
		   });
		  
		  $(document).on("submit",".changeImageForm", function(event){
			    event.preventDefault();
			    var formData = new FormData($(this)[0]);
			    formData.append('id','<?=$subadmin->id;?>');
			   
			   $.ajax({
				  url:"../controller/UserController.php?action=changeProfileImage",
                  type:"POST",	
                  data:formData,
				  processData: false,
                  contentType: false,
				  success:function(response)
				  {
					
					    //console.log(response);
						response = JSON.parse(response);
						
						if(response.status == '1')
						{
							alert(response.message);
						    location.reload();
						}
						else
						{
							alert(response.message);
							
						}
				  }				  
			   });
		   });
		</script>	
    </body>
</html>
