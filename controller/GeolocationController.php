<?php
    require_once '../model/GeolocationModel.php';
	
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	
	switch($action)
	{
		case 'getLocation':
		  try
		  {
			  if(isset($_POST['latitude']) && isset($_POST['longitude']))
			  {
				 $location = new GeolocationModel();
				 $location->getLocation($_POST['latitude'],$_POST['longitude']);
			  }
			  else
			  {
				  die(json_encode(array(
				      'status' => 0,
					  'message' => "Latitue and longitude is not set."
				  )));
			  }
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