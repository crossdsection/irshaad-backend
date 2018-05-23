<?php
  //************ Author : Bhawna Pandey ************//  
 // die('HELLO');
  session_start();
  ob_start();
  
  require_once('../model/Session.php');
  
  $page = basename($_SERVER['PHP_SELF'],'.php');
  
  if(isset($_SESSION['user']))
  {
	   $user = unserialize($_SESSION['user']);
	  if((isset($user->email)) && $user->email != '')
	  {
		  if($page == 'index')
		  {
		    // header('Location:dashboard/index.php');
		  }
		  else
		  {
			 if($page != 'index')
	         {
		         header('Location:index.php');
	         }  
		  }  
	  }
  }
  else if(isset($_SESSION['admin']))
  {
	  $admin = unserialize($_SESSION['admin']);
	  if((isset($admin->email)) && $admin->email != '')
	  {
		  //header('Location:../admin/home.php');
	  }
	  else
	  {
		 header('Location:index.php'); 
	  }
  }
  else if(isset($_SESSION['subAdmin']))
  {
	
	  $subadmin = unserialize($_SESSION['subAdmin']);
	  if((isset($subadmin->email)) && ($subadmin->email != ''))
	  {
	  }
	  else
	  {
		  header('Location:index.php');
	  }
	  
  }
  else
  {
	  if($page != 'index')
	  {
		  header('Location:../view/index.php');
	  }
  }
?>