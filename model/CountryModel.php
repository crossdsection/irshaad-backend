<?php
   require_once '../config/Database.php';
   
   class CountryModel
   {
	  
	   
	   public static function getStates($id)
	   {
		    $db = new Database();
		    $getStates = $db->select("wv_states.id,wv_states.name","wv_states","wv_states.country_id = '{$id}' ");
		   
		   if(count($getStates) > 0)
		   {
			   die(json_encode(array(
			      'status' => 1,
				  'data' => $getStates
 			   )));
		   }
		   else
		   {
			   throw new Exception("No state found.");
		   }
	   }
	   
	   
	   public static function getCity($id)
	   {
		   $db = new Database();
		    $getCities = $db->select("wv_cities.id,wv_cities.name","wv_cities","wv_cities.state_id = '{$id}' ");
		   
		   if(count($getCities) > 0)
		   {
			   die(json_encode(array(
			      'status' => 1,
				  'data' => $getCities
 			   )));
		   }
		   else
		   {
			   throw new Exception("No city found.");
		   }
	   }
   }
?>