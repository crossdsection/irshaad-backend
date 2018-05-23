<?php
    if(!isset($_SESSION))
	{
		session_start();
	}
	
	require_once('../config/Database.php');
	require_once('Session.php');
	
	class LoginModel extends Database
	{
	
		protected $tableName = 'wv_user';
		protected static $table_Name = 'wv_user';
		protected static $table_Name1 = 'wv_authority';
		public function __construct()
		{
			parent::__construct();
		}
		
		public function userLogin($data)
		{
			
			$userLoginData = $this->select("*",$this->tableName,"wv_user.email = '{$data['email']}' and wv_user.email_verified = '1' ");
		
			
			if(count($userLoginData) > 0)
			{
			   $userLoginData = $userLoginData[0];
			   if($userLoginData['password'] == md5($data['password']))
			   {
				  $updateOnlineStatus = $this->update($this->tableName, array('active' => 1), "id= '{$userLoginData['id']}'"); 
			      $details = array(
				        'user_id' => $userLoginData['id'],
						'latitude' => $data['user_address_latitude'],
						'longitude' => $data['user_address_longitude']
				  );
				  
				 $checkLoginRecord = $this->select("*","wv_login_record","wv_login_record.user_id = '{$userLoginData['id']}' and wv_login_record.latitude = '{$data['user_address_latitude']}' and wv_login_record.longitude = '{$data['user_address_longitude']}' ");
				 if(count($checkLoginRecord)>0)
				 {
					 
				 }
			     else{
				 $insertLoginRecord = $this->insert("wv_login_record",$details);
			      }
				  
				  $session = new Session(array(
				                'id' => $userLoginData['id'],
								'firstName' => $userLoginData['firstname'],
								'lastName' => $userLoginData['lastname'],
								'gender' => $userLoginData['gender'],
								'email' => $userLoginData['email'],
								'phone' => $userLoginData['phone'],
								'address' => $userLoginData['address'],
								'profile' => $userLoginData['profilepic']
				  )); 
				  
				  $_SESSION['user'] = serialize($session);
				  
				  die(json_encode(array(
				        'status' => 1,
						'message' => "Login successfully"
				  )));
			   }
			   else
			   {
				  die(json_encode(array(
				       'status' => 0,
					   'message' => "Wrong Password."
				  ))); 
               }				   
			}
			else
			{
				die(json_encode(array(
				       'status' => 0,
					   'message' => "Email is not verified."
				  ))); 
			}
			
		}
		
		public function adminLogin($data)
		{
			$adminLoginData = $this->select("*","wv_authority","email = '{$data['email']}' and autority_role = '{$data['auth_role']}'");
			
			$adminLoginData = $adminLoginData[0];
			
			if($adminLoginData['password'] == md5($data['password']))
			{
				$updateAdminOnlineStatus = $this->update('wv_authority', array('active' => 1), "id = '{$adminLoginData['id']}'");
				 
				
				$session = new Session(array(
				     'id' => $adminLoginData['id'],
					 'firstName' => $adminLoginData['first_name'],
					 'lastName' => $adminLoginData['last_name'],
					 'gender' => $adminLoginData['gender'],
					 'email' => $adminLoginData['email'],
					 'phone' => $adminLoginData['phone'],
					 'address' => $adminLoginData['country_id']."`".$adminLoginData['state_id']."`".$adminLoginData['city_id'],
					 'profile' => $adminLoginData['profile_picture']
				));
				
				$_SESSION['admin'] = serialize($session);
				
				die(json_encode(array(
				     'status' => 1,
					 'message' => 'Login successfully.'
				)));
			}
			else
			{
				die(json_encode(array(
				       'status' => 0,
					   'message' => "Wrong Password."
				  )));
			}
		}
		
		
		
		
		
		public static function logout() 
		{
			if(isset($_SESSION)) 
			{
				if(isset($_SESSION['user']))
				{
					$user = unserialize($_SESSION['user']);
				    $db = new Database();
				    $db->update(self::$table_Name, array('active' => 0), "id = '{$user->id}'");
				}
				else
				{
					$admin = unserialize($_SESSION['admin']);
					$db = new Database();
					$db->update(self::$table_Name1, array('active' => 0), "id = '{$admin->id}'");
				}
			}
			
			if(isset($_SESSION)) 
			{
				session_destroy();
				
		        
			}
			
			die(json_encode(array(
				'status' => 1,
				'message' => "Logout Successful"
			)));
		}
	}

?>