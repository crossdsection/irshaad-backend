<?php include"header.php"; ?>

    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include"leftsidebar.php";?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Add City Ministry</h1>
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
								    $getCountry = $db->select("wv_countries.id,wv_countries.name","wv_countries");
								?>
								<select class="form-control show-state-data" name="country_data">
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
							    <label>State Name</label>
								<select class="form-control show-state" name="state_data">
								    <option value="00">Select State</option>
								</select>
							</div>
							<div class="form-group">
							    <label>City Name</label>
								<select class="form-control show-city" name="city_data">
								    <option value="00">Select City</option>
								</select>
							</div>
							<div class="form-group">
							   <label>Ministry(Department) Name</label>
							   <input class="form-control" placeholder="Enter Ministry or department name" type="text" name="city_ministry_name">
							</div>

							<div class="form-group">
								<label>Profile Pic Head of Ministry(Department)</label>
								<input type="file" class="form-control" name="department_head_pic">
							</div>

								<button type="submit" class="btn btn-primary btn-md">Save</button>

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

				 $.ajax({
					url:'../controller/DepartmentController.php?action=addDeprtment',
					type:'post',
					data:formData,
				    processData: false,
                    contentType: false,
					success:function(response)
					{
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
		</script>
    </body>
</html>
