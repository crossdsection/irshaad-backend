<?php
   if(isset($_POST['latitude']) && isset($_POST['longitude']))
   {
	   $url =  'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false';
	   
	   $json = @file_get_contents($url);
	   $data = json_decode($json);
	   
	   $status = $data->status;
	   
	   if($status == 'OK')
	   {
		  $location = $data->results[0]->formatted_address;
		  $latitude1 = $data->results[0]->geometry->location->lat;
		  $longitude1 = $data->results[0]->geometry->location->lng;
		 
	   }
	   else
	   {
		  $location = '';
	   }
	   
	  
   }
   else
   {
	   echo "Error";
   }
?>