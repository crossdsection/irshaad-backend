<?php
   echo md5('admin');
?>
<!DOCTYPE html>
<html lang="en-US">
   <head>
      <title>Geo Location</title>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
   </head>
   <body>
       <p><span class="label">Your Location:</span> <span id="location"></span></p> 
	   
	   <script>
	     $(document).ready(function(){
			 if(navigator.geolocation)
			 {
				navigator.geolocation.getCurrentPosition(showLocation);
				
			 }
			 else
			 {
				 $("#location").html("Geolocation is not supported by this browser.");
			 }
		 });
		 
		 
		 function showLocation(position)
		 {
			 var latitude = position.coords.latitude;
			 var longitude = position.coords.longitude;
			 
			 $.ajax({
				 type:'POST',
				 url:'geolocation.php',
				 data:{latitude:latitude,longitude:longitude},
				 success:function(response)
				 {
					 console.log(response);
				 }
			 });
			 
		 }
	   </script>
   </body>
</html>