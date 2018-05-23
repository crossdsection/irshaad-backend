<?php
   
   require_once '../model/LoginModel.php';
   
   $action = isset($_GET['action']) ? $_GET['action'] : '';
   
	   switch($action)
	   {
		   case 'userLogin':
		       try
			   {
				   if((isset($_POST['email'])) && ($_POST['email'] != ''))
				   { 
					   if((isset($_POST['password'])) && ($_POST['password'] != ''))
					   {
						   
						//Code for entering the latitude and longitude of the userLogin
                        
						  $data = array(
						          'user_address_latitude' => $_POST['login-user-latitude'],
								  'user_address_longitude' => $_POST['login-user-longitude'], 
				                  'email' => $_POST['email'],
								  'password' => $_POST['password']
								       );
							$login = new LoginModel();
                            $login->userLogin($data);							
					   }
					   else
					   {
						   die(json_encode(array(
						      'status' => 0,
                              'message' => "Password can not be empty."							  
						   )));
					   }
				   }
				   else
				   {
					   die(json_encode(array(
					       'status' => 0,
						   'message' => "Email can not be empty."
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
		   
		    case 'adminLogin':
			    try
				{
					if((isset($_POST['email'])) && ($_POST['email'] != ''))
					{
						if((isset($_POST['password'])) && ($_POST['password'] != ''))
						{
							$data = array(
							       'email' => $_POST['email'],
								   'password' => $_POST['password'],
								   'auth_role' => $_POST['authority_role']
							);
							
							$login = new LoginModel();
							$login->adminLogin($data);
						}
						else
						{
							die(json_encode(array(
							    'status' => 0,
								'message' => 'Password can not be empty.'
							)));
						}
					}
					else
					{
						die(json_encode(array(
						   'status' => 0,
						   'message' => 'Email can not be empty.'
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
		   
		   
		    case 'logout':
			   try
			   {
				  LoginModel::logout();
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