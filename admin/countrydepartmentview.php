<?php 
    include"header.php"; 
     
   if((isset($_GET['view'])) && ($_GET['view'] != ''))
	{
		$getCountryData = $db->select("wv_ministry.*,wv_countries.name","wv_ministry left join wv_countries on wv_ministry.country_id = wv_countries.id","wv_ministry.ministry_status = 1 and wv_ministry.id = '{$_GET['view']}'");
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
                        <h1 class="page-header">View Country Ministry</h1>
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
	
    </body>
</html>
