<?php
  require_once('../model/UserModel.php');
  
  $action = isset($_GET['action']) ? $_GET['action'] : '';
  
  switch($action)
  {
	   case 'userSignup':
	     try
		 {
			/* print_r($_POST);
			 die();*/
			 if($_POST['password'] != $_POST['confirm_password'])
			 {
				 die(json_encode(array(
				      'status' => 0,
					  'message' => "Password and confirm password does not match."
				 )));
			 }
			 
			 require_once('../model/GeolocationModel.php');
			 $location = new GeolocationModel();
			 $locationData = $location->getLocation($_POST['signup-user-latitude'],$_POST['signup-user-longitude']);
			
			 if($locationData['status'] != 0)
			 {
				 $longlat = explode("`", $locationData['data']);
				 
				 $_POST['user_address'] = $longlat[0];
                 $_POST['user_address_latitude'] = $longlat[1];
				 $_POST['user_address_longitude'] = $longlat[2];				 
			 }
			 else
			 {
				$_POST['user_address'] = ''; 
				$_POST['user_address_latitude'] = '';
				$_POST['user_address_longitude'] = '';
			
			 }
			 // echo $_POST['user_address']." ".$_POST['user_address_latitude']." ".$_POST['user_address_longitude'];
			 // echo $locationData->status;
			 
			  $user = new UserModel('',$_POST,'');
			  $user->userSignup();
			 
		 }
		 catch(Exception $ex)
		 {
			 die(json_encode(array(
			      'status' => 0,
				  'message' => $ex->getMessage()
			 )));
		 }
	   break;
	   
	    case 'subAdminSignup':
		
	     try
		 {
			 /*print_r($_POST);
			 print_r($_FILES);*/
			 if((isset($_POST['type_flag']))  && ($_POST['type_flag'] != 0))
			 {
				 if((isset($_FILES['authority_position_certificate']))  &&  ($_FILES['authority_position_certificate']['tmp_name'] != ''))
				 {
					$user = new UserModel('',$_POST,$_FILES);
			        $user->subAdminSignup(); 
				 }
				 else
				 {
					 die(json_encode(array(
					    'status' => 0,
                        'message' => "Upload certificate is required" 						
					 )));
				 }
			 }
			 else
			 {
			    $user = new UserModel('',$_POST,'');
			    $user->subAdminSignup();
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
	   
	    case "verifyEmail":
		
			  try
			  {
				$user = new UserModel('verify',$_POST,'');
			    $user->verifyEmail();
			  }
			  catch(Exception $e)
			  {
				  die(json_encode(array(
				   'status'=> 0,
				   'message'=> $e->getMessage()
				  )));
			  }
        
        break;
		//when user login with the gmail
		case "gmailLogin":
		
		 try
			  {
				  require_once('../model/GeolocationModel.php');
			      $location = new GeolocationModel();
			      $locationData = $location->getLocation($_POST['latitude'],$_POST['longitude']);
				  
			
			 if($locationData['status'] != 0)
			 {
				 $longlat = explode("`", $locationData['data']);
				 
				 $_POST['user_address'] = $longlat[0];
                 $_POST['user_address_latitude'] = $longlat[1];
				 $_POST['user_address_longitude'] = $longlat[2];				 
			 }
			 else
			 {
				$_POST['user_address'] = ''; 
				$_POST['user_address_latitude'] = '';
				$_POST['user_address_longitude'] = '';
			
			 }
				  
				$user = new UserModel('googleLogin',$_POST,'');
			    $user->gmailLogin();
			  }
			  catch(Exception $e)
			  {
				  die(json_encode(array(
				   'status'=> 0,
				   'message'=> $e->getMessage()
				  )));
			  }
        
        break;
		
		case "verifySubAdminEmail":
		       try
			   {
				   $subAdminVerify = new UserModel('verifySubAdminEmail',$_POST,'');
				   $subAdminVerify->verifySubAdminEmail();
			   }
			   catch(Exception $e)
			   {
				   die(json_encode(array(
				   'status'=>0,
				   'message'=> $e->getMessage()
				   )));
			   }
		
		
		break;
		
		case 'subadminProfileSetting':
		   try
			{
				//print_r($_POST);
			   $user = new UserModel('profile',$_POST,'');
			   $user->subadminProfileSetting();
			   
			}
			catch(Exception $ex)
			{
				die(json_encode(array(
				   'status'=>0,
				   'message'=> $ex->getMessage()
				)));
			}
		  break;
	   
	    case 'changeProfileImage':
		   try
		   {
			   if((isset($_FILES['department_head_pic'])) && ($_FILES['department_head_pic']['tmp_name'] != ''))
			   {
				   $data = array(
				                 'id' => $_POST['id']
				                );
								
					$user = new UserModel('image',$data,$_FILES);
					$user->changeProfileImage();
			   }
			   else
			   {
				   die(json_encode(array(
				      'status' => 0,
					  'message' => "No image has chosen"
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