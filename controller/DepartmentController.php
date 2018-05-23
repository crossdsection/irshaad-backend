<?php
    
   require_once '../model/DepartmentModel.php';
   
    $action = isset($_GET['action']) ? $_GET['action'] : '';
	
	switch($action)
	{
		case 'getDepartment':
		   try
		   {
			   $department = new DepartmentModel('department', $_POST, '');
			   $result = $department->getDepartment();
		   }
		   catch(Exception $ex)
		   {
			   die(json_encode(array(
				   'status'=> 0,
				   'message'=> $ex->getMessage()
				  )));
		   }
		break;
		
		case 'addDeprtment' :
		
		   try
		   {
			   
			   if((isset($_POST['world_ministry_name'])) && ($_POST['world_ministry_name'] != ''))
			   {
				   $ministryName = $_POST['world_ministry_name'];
				   $ministryStatus = 0;
				   $countryId = '';
				   $stateId = '';
				   $cityId = '';
			   }
			   else if((isset($_POST['country_ministry_name'])) && ($_POST['country_ministry_name'] != ''))
			   {
				   $ministryName = $_POST['country_ministry_name'];
				   $ministryStatus = 1;
				   $countryId = $_POST['country_data'];
				   $stateId = '';
				   $cityId = '';
			   }
			   else if((isset($_POST['state_ministry_name'])) && ($_POST['state_ministry_name'] != ''))
			   {
				   $ministryName = $_POST['state_ministry_name'];
				   $ministryStatus = 2;
				   $countryId = $_POST['country_data'];
				   $stateId = $_POST['state_data'];
				   $cityId = ''; 
			   }
			   else
			   {
				   $ministryName = $_POST['city_ministry_name'];
				   $ministryStatus = 3;
				   $countryId = $_POST['country_data'];
				   $stateId = $_POST['state_data'];
				   $cityId = $_POST['city_data']; 
			   }
			   
			   $data = array(
			            'ministryName' => $ministryName,
						'countryId' => $countryId,
						'stateId' => $stateId,
						'cityId' => $cityId,
						'ministryStatus' => $ministryStatus
			   );
			  
			   $department = new DepartmentModel('', $data, $_FILES);
			   $result = $department->addDepartment();   
		   }
		   catch(Exception $ex)
		   {
			   die(json_encode(array(
			        'status' => 0,
					'message' => $ex->getMessage()
			    )));
		   }
		break;
		
		case 'deleteDepartment':
		    try
			{
				$department = new DepartmentModel('id', $_POST, '');
				$result = $department->deleteDepartment();
			}
			catch(Exception $ex)
			{
				die(json_encode(array(
				   'status' => 0,
				   'message' => $ex->getMessage()
				)));
			}
		break;
		
		case 'editDepartment':
		    try
			{
			   if((isset($_POST['world_ministry_name'])) && ($_POST['world_ministry_name'] != ''))
			   {
				   $data = array(
				               'ministryName' => $_POST['world_ministry_name'],
							   'ministryStatus' => $_POST['department_ministry_status'],
							   'departmentId' => $_POST['department_id']
				   );
			   }
			   else if((isset($_POST['country_ministry_name'])) && ($_POST['country_ministry_name'] != ''))
			   {
				    $data = array(
				               'ministryName' => $_POST['country_ministry_name'],
							   'ministryStatus' => $_POST['department_ministry_status'],
							   'departmentId' => $_POST['department_id'],
							   'countryId' => $_POST['country_data']
				   );
			   }
			   else if((isset($_POST['state_ministry_name'])) && ($_POST['state_ministry_name'] != ''))
			   {
				   $data = array(
				               'ministryName' => $_POST['state_ministry_name'],
							   'ministryStatus' => $_POST['department_ministry_status'],
							   'departmentId' => $_POST['department_id'],
							   'countryId' => $_POST['country_data'],
							   'stateId' => $_POST['state_data']
				   );
			   }
			   else
			   {
				    $data = array(
				               'ministryName' => $_POST['city_ministry_name'],
							   'ministryStatus' => $_POST['department_ministry_status'],
							   'departmentId' => $_POST['department_id'],
							   'countryId' => $_POST['country_data'],
							   'stateId' => $_POST['state_data'],
							   'cityId' => $_POST['city_data']
				   );
			   }
			   $department = new DepartmentModel('edit', $data, '');
			   $result = $department->editDepartment();
			}
			catch(Exception $ex)
			{
				die(json_encode(array(
				   'status' => 0,
				   'message' => $ex->getMessage()
				)));
			}
		break;
		
		case 'changeDepartmentImage':
		   try
		   {
			  /* print_r($_POST);
			   print_r($_FILES);*/
			   if((isset($_FILES['department_head_pic'])) && ($_FILES['department_head_pic']['tmp_name'] != ''))
			   {
				   $data = array(
				              'departmentId' => $_POST['department_id']							  
							  );
					
					$department = new DepartmentModel('image',$data,$_FILES);
					$result = $department->changeDepartmentImage();
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