<?php
   require_once '../model/CountryModel.php';
   
   $action = isset($_GET['action'])? $_GET['action'] : '';
   
   switch($action)
   {
	   case 'getState':
	       try
		   {
			 CountryModel::getStates($_POST['country_id']);
		   }
		   catch(Exception $ex)
		   {
			   die(json_encode(array(
				  'status' => 0,
				  'message' => $ex->getMessage()
			   )));
		   }
	   break;
	   
	   case 'getCity':
	       try
		   {
			   CountryModel::getCity($_POST['state_id']);
		   }
		   catch(Exception $ex)
		   {
			   die(json_encode(array(
				  'status' => 0,
				  'message' => $ex->getMessage()
			   )));
		   }
	   break;
		
		default:
		die('Forbidden');
   }

?>