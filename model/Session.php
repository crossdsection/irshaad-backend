<?php

  require_once 'UserModel.php';
  class Session
  {
	  public $id;
	  public $firstName;
	  public $lastName;
	  public $gender;
	  public $email;
	  public $phone;
	  public $address;
	  public $profile;
	  
	  public function __construct($data = '')
	  {
		  if($data != '')
		  {
			$this->id = $data['id'];
			$this->firstName = $data['firstName'];
			$this->lastName = $data['lastName'];
			$this->gender = $data['gender'];
			$this->email = $data['email'];
			$this->phone = $data['phone'];
			$this->address = $data['address'];
			$this->profile = $data['profile'];
		  }
		  else
		  {
			die(json_encode(array(
			      'status' => 0,
				  'message' => "Unable to initialize session"
			  )));
		  }
	  }
  }
?>