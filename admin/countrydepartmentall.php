<?php 
    include"header.php"; 
    
	$getWorldData = $db->select("wv_ministry.*,wv_countries.name","wv_ministry left join wv_countries on wv_ministry.country_id = wv_countries.id","wv_ministry.ministry_status = 1");
	
?>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include"leftsidebar.php";?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="page-header">View Country Ministry</h1>
                    </div>
					<div class="col-lg-4">
					   <button type="button" class="btn btn-primary btn-md add-department" style="float:right;margin-top:40px;">Add</button>
					</div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
					    <div class="panel panel-default">
						    <div class="panel-heading">
							     <h4><i class="fa fa-building fa-fw"></i> &nbsp; &nbsp;Country Departments</h4>
							</div>
							<div class="panel-body">
							    <div class="dataTable_wrapper">
								    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
									    <thead>
                                            <tr>
                                                <th>Serial No.</th>
												<th>Ministry/Department Name</th>
												<th>Country</th>
                                                <th>Head Profile Pic</th>
                                                <th>View / Edit</th>
                                                
                                            </tr>
                                        </thead>
										<tbody>
										   <?php
										      if(count($getWorldData) > 0)
											  {
												  $i=1;
												 foreach($getWorldData as $getWorld)
												 {
										   ?>
										   <tr class="odd gradeX" >
                                                <td><?=$i;?></td>
                                                <td><?=$getWorld['ministry_name'];?></td>
                                                <td><?=$getWorld['name'];?></td>
												<td class="center">
												    
                                                   <?php
												       if($getWorld['ministry_head_profilepic'] != '')
													   {
														   ?>
														<img src="../assets/images/department/<?=$getWorld['ministry_head_profilepic'];?>" width="80px;" height="80px;">   
												<?php	   
												       }
													   else
													   {
														   ?>
														<img src="../assets/images/department/no_image_user.png" width="80px;" height="80px;">  
												<?php	   
												       }
												   ?>
                                                    											   
												</td>
                                                <td class="center"><a href="countrydepartmentedit.php?edit=<?=$getWorld['id'];?>">Edit</a>&nbsp;|&nbsp;<a href="countrydepartmentview.php?view=<?=$getWorld['id'];?>" >View</a>&nbsp;|&nbsp;<a href="javascript:void(0);" class="delete-department" value="<?=$getWorld['id'];?>">Delete</a> </td>
                                            </tr>
                                           <?php
										         $i++;
												 }
											  }
										   ?>
										</tbody>
									</table>
								</div>
							</div>
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
		  /******* Code for add department **********/ 
		    $(document).on("click", ".add-department", function(){
				 window.location.href = "countrydepartment.php";
			});
		 

		   /****** Code for delete department ********/
		   $(document).on("click", ".delete-department", function(){
			    var row = $(this);
			    var world_department_id = $(this).attr('value');
				var data = window.confirm("Are you sure want to delete department.");
				if(data == true)
				{
					$.ajax({
						url:'../controller/DepartmentController.php?action=deleteDepartment',
						type:'POST',
						data:{department_id:world_department_id},
						success:function(response)
						{
							//console.log(response);
							response = JSON.parse(response);
							if(response.status == 1)
							{
								 row.parents("tr").remove();
							}
							else
							{
								alert(response.message);
							}
						}
					});
				}
				 
		   });
		
		</script>
    </body>
</html>
