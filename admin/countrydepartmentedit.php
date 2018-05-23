<?php 
    include"header.php"; 
     
    if((isset($_GET['edit'])) && ($_GET['edit'] != ''))
	{
		$getCountryData = $db->select("wv_ministry.*,wv_countries.name","wv_ministry left join wv_countries on wv_ministry.country_id = wv_countries.id","wv_ministry.ministry_status = 1 and wv_ministry.id = '{$_GET['edit']}'");
		if(count($getCountryData) > 0)
		{
			$getCountryData = $getCountryData[0];
			
		}
		else
		{
		   echo "Data does not exists."; 
			exit();
		}
	}
	else
    {
		header('Location:countrydepartmentall.php');
	}
?>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include"leftsidebar.php";?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Edit Country Ministry</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
					   <form  class="country-ministry" method="POST">
					        <div class="form-group">
							    <label>County Name</label>
								<?php
								    $getCountry = $db->select("wv_countries.id,wv_countries.name","wv_countries","wv_countries.id != '{$getCountryData['country_id']}'");
								?>
								<select class="form-control" name="country_data">
								    <option value="00">Select Country</option>
									<option value="<?=$getCountryData['country_id']?>" selected><?=$getCountryData['name']?></option>
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
							   <label>Ministry(Department) Name</label>
							   <input class="form-control" placeholder="Enter Ministry or department name" type="text" name="country_ministry_name" value = "<?=$getCountryData['ministry_name'];?>">
							</div> 
							<input type="hidden" name="department_ministry_status" value="<?=$getCountryData['ministry_status'];?>">
							
							
								<button type="submit" class="btn btn-primary btn-md">Save</button>
								
						</form>	
                    </div>
					<div class="col-sm-6 col-md-6 col-lg-6">
					     <form action="" method="post" class="changeImageForm" enctype="multipart/form-data">
						    <div class="form-group">						
								<label>Profile Pic Head of Ministry(Department)</label><br/>
								<?php
								  if($getCountryData['ministry_head_profilepic'] != '')
								  {
									 
                         			?>
									 <img src="../assets/images/department/<?=$getCountryData['ministry_head_profilepic'];?>" width="300px;" height="300px;">   
							<?php	  }
								  else
								  {
									  ?>
									  <img src="../assets/images/department/no_image_user.png" width="300px;" height="300px;">
							<?php	  }
								?>
								
								
							</div>
							<div class="form-group">
							    
								<input type="file" class="form-control" name="department_head_pic" id="department_head_pic_id">
								<label for="department_head_pic_id" class="btn btn-danger btn-md">Change Image</label>
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
		   $(document).on("submit", ".country-ministry", function(event){
			   event.preventDefault();
			   var country_name = $(this).find('select[name="country_data"]').val();
			   
			   if(country_name == '00')
			   {
				   alert("Select country name.");
				   return;
			   }
			   
			    var ministry_name = $(this).find('input[name="country_ministry_name"]').val();
			    
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
