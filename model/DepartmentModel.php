<?php
 
  require_once('../config/Database.php');
  
  class DepartmentModel extends Database
  {
	 protected $tableName = "wv_ministry"; 
	 public $id;
	 public $ministryName;
	 public $countryId;
	 public $stateId;
	 public $cityId;
	 public $ministryStatus;
	 public $fileLink;
	 
	 public function __construct($flag = '', $data = '', $file = '')
	 {
		 parent::__construct();
		 if($flag == '')
		 {
			 if($data != '')
			 {
				
				 if((isset($data['ministryName'])) && ($data['ministryName'] != ''))
				 {
					 $this->ministryName = filter_var($data['ministryName'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					 throw new Exception("Ministry Name is required.");
				 }
				 
				 if((isset($data['countryId'])) && ($data['countryId'] != ''))
				 {
					 $this->countryId = filter_var($data['countryId'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					$this->countryId = '';
                 }	

                 if((isset($data['stateId'])) && ($data['stateId'] != ''))
				 {
					 $this->stateId = filter_var($data['stateId'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					 $this->stateId = '';
                 }	

                 if((isset($data['cityId'])) && ($data['cityId'] != ''))
				 {
					 $this->cityId = filter_var($data['cityId'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					 $this->cityId = '';
                 }

                 if((isset($data['ministryStatus'])) && ($data['ministryStatus'] !== ''))
				 {
					$this->ministryStatus = filter_var($data['ministryStatus'], FILTER_SANITIZE_NUMBER_INT);
				 }
				 else
				 {
					throw new Exception("Ministry status is required.");
                 }

                if((isset($file['department_head_pic'])) && ($file['department_head_pic']['tmp_name'] != ''))
				{	
			         $this->fileLink = $file['department_head_pic'];
                }
                else
                {
					$this->fileLink = '';
                }					
			 }
			 else
			 {
				 throw new Exception("No data pass");
			 }
		 }
		 else if($flag == 'id')
		 {
			if($data != '')
			{
				if(isset($data['department_id']))
				{
					$this->id = filter_var($data['department_id'], FILTER_SANITIZE_NUMBER_INT);
				}
				else
				{
					throw new Exception("No id pass.");
				}
			}
		 }
		 else if($flag == 'department')
		 {
			 if($data != '')
			 {
				/* */
				 
				 if((isset($data['ministry_flag'])) && ($data['ministry_flag'] != ''))
				 {
					$this->ministryStatus = filter_var($data['ministry_flag'], FILTER_SANITIZE_STRING); 
				 }
				 else
				 {
					 throw new Exception("Ministry status is required."); 
				 }
				 
				 if((isset($data['country_id'])) && ($data['country_id'] != ''))
				 {
					 $this->countryId = filter_var($data['country_id'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					 throw new Exception("Country is required.");
				 }
				 
				 if((isset($data['state_id'])) && ($data['state_id'] != ''))
				 {
					 $this->stateId = filter_var($data['state_id'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					 throw new Exception("State is required.");
				 }
				 
				 if((isset($data['city_id'])) && ($data['city_id'] != ''))
				 {
					$this->cityId = filter_var($data['city_id'], FILTER_SANITIZE_STRING);
				 }
				 else
				 {
					 throw new Exception("City is required.");
				 }
				 
				 
			 }
			 else
			 {
				 throw new Exception("Invalid data");
			 }
		 }
		 else if($flag == 'image')
		 {
			 if($data != '')
			 {
				 if((isset($data['departmentId'])) && ($data['departmentId'] != ''))
				 {
					 $this->id = $data['departmentId'];
				 }
				 else
				 {
					 throw new Exception("No department id set");
				 }
				 
				 if((isset($file['department_head_pic'])) && ($file['department_head_pic']['tmp_name'] != ''))
				 {
					 $this->fileLink = $file['department_head_pic'];
				 }
				 else
				 {
					 throw new Exception("No image set");
				 }
			 }
			 else
			 {
				 throw new Exception("Invalid data");
			 }
		 }
		 else if($flag == 'edit')
		 {
			 if($data != '')
			 {
				 
				  if((isset($data['ministryName'])) && ($data['ministryName'] != ''))
				  {
					  $this->ministryName = filter_var($data['ministryName'], FILTER_SANITIZE_STRING);
				  }
				  else
				  {
					  throw new Exception("Ministry name is required.");
				  }
				  
				  if((isset($data['ministryStatus'])) && ($data['ministryStatus'] !== ''))
				  {
					  $this->ministryStatus = filter_var($data['ministryStatus'], FILTER_SANITIZE_NUMBER_INT);
				  }
				  else
				  {
					  throw new Exception("Ministry status is required.");
				  }
				  
				  if((isset($data['departmentId'])) && ($data['departmentId'] != ''))
				  {
					 $this->id = filter_var($data['departmentId'],FILTER_SANITIZE_NUMBER_INT); 
				  }
				  else
				  {
					  throw new Exception("Id is not set");
				  }
				  
				  if((isset($data['countryId'])) && ($data['countryId'] != ''))
				  {
					 $this->countryId = filter_var($data['countryId'], FILTER_SANITIZE_NUMBER_INT); 
				  }
				  else
				  {
					  $this->countryId = 0;
				  }
				  
				  if((isset($data['stateId'])) && ($data['stateId']  != ''))
				  {
					  $this->stateId = filter_var($data['stateId'], FILTER_SANITIZE_NUMBER_INT);
				  }
				  else
				  {
					  $this->stateId = 0;
				  }
				  
				  if((isset($data['cityId'])) && ($data['cityId'] != ''))
				  {
					  $this->cityId = filter_var($data['cityId'], FILTER_SANITIZE_NUMBER_INT);
				  }
				  else
				  {
					  $this->cityId = 0;
				  }
			 }
			 else
			 {
				 throw new Exception("Invalid data");
			 }
		 }
		 else
		 {
			 throw new Exception("Something went worng");
		 }
	 }
	 
	 public function getDepartment()
	 {
		 $result = $this->select("*",$this->tableName,"country_id = '{$this->countryId}' and state_id = '{$this->stateId}' and 	city_id = '{$this->cityId}' and  ministry_status = '{$this->ministryStatus}' ");
		 
		 if(count($result) > 0)
		 {
			  die(json_encode(array(
			    'status' => 1,
				'data' => $result
			  )));
		 }
		 else
		 {
			 die(json_encode(array(
			     'status' => 0,
				 'message' => "No Department found"
			 )));
		 }
	 }
	 
	 
	  public function addDepartment()
	  {
		  $image = $this->addImage($this->fileLink);
		  $details = array(
		            'ministry_name' => $this->ministryName,
					'country_id' => $this->countryId,
					'state_id' => $this->stateId,
					'city_id' => $this->cityId,
					'ministry_status' => $this->ministryStatus,
					'ministry_head_profilepic' => $image
					
		  );
		  
		 $insertDepartment = $this->insert($this->tableName,$details);
		 if($insertDepartment != false)
		 {
			die(json_encode(array(
			    'status' => 1,
				'message' => 'Department inserted.'
			))); 
		 }
		 else
		 {
			 die(json_encode(array(
			    'status' => 0,
				'message' => 'Error in department insertion.'
			 )));
		 }
	  }
	  
	  public function changeDepartmentImage()
	  {
		  $image = $this->addImage($this->fileLink);
		  
		  $getDepartmentImage = $this->select("wv_ministry.ministry_head_profilepic","wv_ministry","wv_ministry.id = '{$this->id}'");
		  
          if(count($getDepartmentImage) > 0)
		  {
			 $getDepartmentImage = $getDepartmentImage[0];
			 
			 if($getDepartmentImage['ministry_head_profilepic'] != '')
			 {
				 unlink('../assets/images/department/'.$getDepartmentImage['ministry_head_profilepic']);
			 }
			 
			 $result = $this->update($this->tableName, array('ministry_head_profilepic' => $image),"wv_ministry.id = '{$this->id}'");
			 
			 if($result != false)
			 {
				 die(json_encode(array(
				     'status' => 1,
					 'message' => 'Image is updated successfully'
				 )));
			 }
			  
		  }
		  else
		  {
			  die(json_encode(array(
			       'status' => 0,
				   'message' => 'No data found'
			  )));
		  }
		 
	  }
	  
	  
	  
	  
	  public function deleteDepartment()
	  {
		  $getDepartment = $this->select("ministry_head_profilepic",$this->tableName,"id= '{$this->id}'");
		  
		  if(count($getDepartment)  > 0)
		  {
			  $getDepartment = $getDepartment[0];
			  if($getDepartment['ministry_head_profilepic'] != '')
			  {
				  unlink('../assets/images/department/'.$getDepartment['ministry_head_profilepic']); 
			  }
		  }
		  
		  $deleteDepartment = $this->delete($this->tableName,"id= '{$this->id}'");
		  if($deleteDepartment != false)
		  {
			  die(json_encode(array(
			      'status' => 1,
				  'message' => "Department deleted successfully"
			  )));
		  }
		  else
		  {
			  die(json_encode(array(
			     'status' => 0,
				 'message' => "Error in delete department"
			  )));
		  }
		  
	  }
	  
	  
	  public function editDepartment()
	  {
		  
		  $details = array(
		                'ministry_name' => $this->ministryName,
						'country_id' => $this->countryId,
						'state_id' => $this->stateId,
						'city_id' => $this->cityId
		             ); 
					 
			$updateDepartment = $this->update($this->tableName,$details,"wv_ministry.id = '{$this->id}' and wv_ministry.ministry_status = '{$this->ministryStatus}'");
			
			if($updateDepartment != false)
			{
				die(json_encode(array(
				    'status' => 1,
					'message' => "Department is updated successfully."
				)));
			}
			else
			{
				die(json_encode(array(
				     'status' => 0,
					 'message' => "Department is not updated"
				)));
			}
			
		  
	  }
  }

?>