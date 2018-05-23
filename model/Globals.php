<?php
   //*******Author:Bhawna Pandey********//
   
   
   class Globals
   {
      public static $emailImagePath = "http://localhost/worldvoting/";
    
      public static function getMonth($month)
	  {
        
        return  $monthName = date('F', mktime(0, 0, 0, $month, 10));
      }
   
      public static function getDateFormat($date)
	  {
          if($date=='')
		  {
             die();
          }
         
 		 $d=explode('-',$date);
         $month= self::getMonth($d[1]);
         return $new_date=$month.' '.$d[2].','.$d[0];
      }
    }
?>