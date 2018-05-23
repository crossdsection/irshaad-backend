<?php
   
   class GeolocationModel
   {
	   function getLocation($lat,$lng)
	   {
		   
		  $url =  'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
	      
		  $json = @file_get_contents($url);
	      $data = json_decode($json);
	   
	      $status = $data->status;
	   
		   if($status == 'OK')
		   {
			  $location = $data->results[0]->formatted_address;
			  $latitude1 = $data->results[0]->geometry->location->lat;
			  $longitude1 = $data->results[0]->geometry->location->lng;
			  
			return array(
			      'status' => 1,
				  'data' => $location."`".$latitude1."`".$longitude1,
				  'message' => "Geolocation successfully get."
			  );
			 //echo $location."`".$latitude1."`".$longitude1;
			 
		   }
		   else
		   {
			  //throw new Exception("Not able to get location");
			  return array(
			     'status' => 0,
				 'message' => "Not able to get location."
			  );
		   }
	   }
   }
   
?>