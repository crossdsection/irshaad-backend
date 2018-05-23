<?php include"header.php"; 
  
  	
	if((isset($_GET['view'])) && ($_GET['view'] != ''))
	{
		$getCityData = $db->select("wv_ministry.*,wv_countries.name as country_name,wv_states.name as state_name,wv_cities.name as city_name","wv_ministry left join wv_countries on wv_ministry.country_id = wv_countries.id left join wv_states on wv_ministry.state_id = wv_states.id left join wv_cities on wv_ministry.city_id = wv_cities.id","wv_ministry.ministry_status = 3 and wv_ministry.id = '{$_GET['view']}'");
		
		if(count($getCityData) > 0)
		{
			$getCityData = $getCityData[0];
		   print_r($getCityData);
		}
		else
		{
			echo "Data does not exists."; 
			exit();
		}
		
	}
	else
	{
		header('Location:citydepartmentall.php');
	}
?>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include"leftsidebar.php";?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">View City Ministry</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
					   <form  class="city-ministry" method="POST">
					        <div class="form-group">
							    <label>County Name</label>
								<?php
								    $getCountry = $db->select("wv_countries.id,wv_countries.name","wv_countries","wv_countries.id != '{$getCityData['country_id']}'");
								?>
								<select class="form-control show-state-data" name="country_data">
								    <option value="00">Select Country</option>
									<option value="<?=$getCityData['country_id']?>" selected><?=$getCityData['country_name']?></option>
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
							    <label>State Name</label>
								<select class="form-control show-state" name="state_data">
								    <option value="00">Select State</option>
									<option value="<?=$getCityData['state_id'];?>" selected><?=$getCityData['state_name'];?></option>
								</select>
							</div>
							<div class="form-group">
							    <label>City Name</label>
								<select class="form-control show-city" name="city_data">
								    <option value="00">Select City</option>
									<option value="<?=$getCityData['city_id'];?>" selected><?=$getCityData['city_name'];?></option>
								</select>
							</div>
							<div class="form-group">
							   <label>Ministry(Department) Name</label>
							   <input class="form-control" placeholder="Enter Ministry or department name" type="text" name="city_ministry_name" value="<?=$getCityData['ministry_name'];?>">
							</div> 
							<input type="hidden" name="department_ministry_status" value="<?=$getCityData['ministry_status'];?>">	
							
							
								
						</form>	
                    </div>
				    <div class="col-sm-6 col-md-6 col-lg-6">
					     <form action="" method="post" class="changeImageForm" enctype="multipart/form-data">
						    <div class="form-group">						
								<label>Profile Pic Head of Ministry(Department)</label><br/>
								<?php
								    if($getCityData['ministry_head_profilepic'] != '')
									{
										 ?>
										 <img src="../assets/images/department/<?=$getCityData['ministry_head_profilepic'];?>" width="300px;" height="300px;">
								<?php	}
									else
									{
										 ?>
										 <img src="../assets/images/department/no_image_user.png" width="300px;" height="300px;">
								<?php	
								    }
								?>
								   
							</div>
							
						
						 </form>
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
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
			 $(document).ready(function() {
                $('#userTable').DataTable({
                        responsive: true
                });
            });
        </script>
			<script>
		   $(document).on("submit", ".city-ministry", function(event){
			   event.preventDefault();
			   var country_name = $(this).find('select[name="country_data"]').val();
			   
			   if(country_name == '00')
			   {
				   alert("Select country name.");
				   return;
			   }
			   
			   var state_name = $(this).find('select[name="state_data"]').val();
			   
			   if(state_name == '00')
			   {
				   alert("Select state name.");
				   return;
			   }
			   
			   
			   var city_name = $(this).find('select[name="city_data"]').val();
			   
			   if(city_name == '00')
			   {
				   alert("Select city name.");
				   return;
			   }
			   
			   
			   var ministry_name = $(this).find('input[name="city_ministry_name"]').val();
			    
				if(ministry_name == '')
				{
					alert("Enter ministry name.");
					return;
				}
				
				 var formData = new FormData($(this) [0]);
				 formData.append('department_id','<?=$_GET['edit']?>');
				 
				 $.ajax({
					url:'../controller/DepartmentController.php?action=editDepartment',
					type:'post',
					data:formData,
				    processData: false,
                    contentType: false,
					success:function(response)
					{
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
		   
		   
		   
		    $("#department_head_pic_id").change(function(){
			   $(".changeImageForm").submit();
		   });
		   
		   $(document).on("submit",".changeImageForm", function(event){
			    event.preventDefault();
			    var formData = new FormData($(this)[0]);
			    formData.append('department_id','<?=$_GET['edit']?>');
			   
			   $.ajax({
				  url:"../controller/DepartmentController.php?action=changeDepartmentImage",
                  type:"POST",	
                  data:formData,
				  processData: false,
                  contentType: false,
				  success:function(response)
				  {
					
					    console.log(response);
						response = JSON.parse(response);
						
						if(response.status == '1')
						{
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
