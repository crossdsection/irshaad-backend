<?php
   /********Author:Bhawna********/
   if(function_exists('date_default_timezone_set'))
   {
            date_default_timezone_set('Asia/Kolkata');
   }

   class Database
   {
	   private $user = 'root';
	   private $pass = 'backspace';
	   private $database = 'worldvoting';
	   private $link = '';
	   protected $_tableName = '';
	   private static $image_ext = ["png", "PNG", "jpg", "jpeg", "JPEG", "JPG"];
	   private static $postUploadPath = '../assets/images/';

	   public function __construct()
	   {
		   try
		   {
			   $this->link = new PDO("mysql:host=localhost;dbname=".$this->database.";charset=UTF8",$this->user,$this->pass);

		   }
		   catch(PDOException $e)
		   {
			   die('Connection failed: '.$e->getMessage());
		   }
	   }

	   //***************************** Select Query ***************************//

	   public function select($columns = "*", $table = "", $condition = "1=1" , $extra = "")
	   {
		   if($table != '')
		   {
			   $this->_tableName = $table;
		   }

		  $query = "SELECT ".$columns." FROM ".$this->_tableName." WHERE ".$condition." ".$extra;
		   try
		   {
			  $result = $this->link->query($query);
			  if($result == true)
			  {
				  $execute = $result->fetchAll(PDO::FETCH_ASSOC);
				  return $execute;
			  }
			  else
			  {
				  $execute = $this->link->errorInfo();
				  die($execute[2]);
			  }
		   }
		   catch(PDOException $e)
		   {
			   die('Error :'.$e->getMessage());
		   }
	   }

	   //*************************** Insert Query ******************************//

	   public function insert($table = "", $data = array())
	   {
		   if($table != '')
		   {
			   $this->_tableName = $table;
		   }
		   $column = '';
		   $values = '';
		   $comma = 0;

		   foreach($data as $key => $value)
		   {
			   if($comma == 0)
			   {
				   $column .= "`".$key."`";
				   $values .= "'".$value."'";
				   $comma = 1;
			   }
			   else
			   {
				   $column .= ", `".$key."`";
				   $values .= ", '".$value."'";
			   }
		   }
		   try
		   {
			   $query = "INSERT INTO ".$this->_tableName." (".$column.") VALUES(".$values.")";

   			   $result = $this->link->query($query);
			   if($result != false)
			   {
				   return $result;
			   }
			   else
			   {
				   $execute = $this->link->errorInfo();
				   if($execute[1] == 1062)
				   {
                      throw new Exception("Email already Exists.");
                   }
                   else
				   {
                      throw new Exception($execute[2]);
                   }
			   }
		   }
		   catch(PDOException $e)
		   {
			   die('Error :'.$e->getMessage());
		   }
	   }

	   //************************* Last Insert Id *********************//

		public function lastInsertId()
        {
            return $this->link->lastInsertId();
        }

	   //************************** Update Query ******************************//

	   public function update($table="", $data = array(), $where = "1=1")
	   {
		   if($table != '')
		   {
			 $this->_tableName  = $table;
		   }
		   $command = "";
		   $comma = 0;

		   foreach($data as $key => $value)
		   {
			   $column = "`".$key."`";
			   $values = "'".$value."'";
			   if($comma == 0)
			   {
				   $command .= $column." = ".$values;
                   $comma = 1;
			   }
			   else
			   {
				   $command .= ", ".$column." = ".$values;
			   }
		   }

		   try
		   {
			  $query = "UPDATE ".$this->_tableName." SET ".$command." WHERE ".$where;
			  $result = $this->link->query($query);

			  if($result != false)
			  {
				  return $result;
			  }
              else
              {
				 $execute = $this->link->errorInfo();
                 die($execute[2]);
              }

		   }
		   catch(PDOException $e)
		   {
			   die('Error :'.$e->getMessage());
		   }
	   }

	   //************************** Delete Query ****************************//

	   public function delete($table="", $condition = "1=1")
	   {
		   if($table != '')
		   {
			   $this->_tableName = $table;
		   }

		   try
		   {
			   $query = "DELETE FROM ".$this->_tableName." WHERE ".$condition;
			   $result = $this->link->query($query);
			   if($result != false)
			   {
				   return $result;
			   }
			   else
			   {
				   $execute = $this->link->errorInfo();
				   die($execute[2]);
			   }
		   }
		   catch(PDOException $e)
		   {
			   die('Error :'.$e->getMessage());
		   }
	   }


   //**************** Email Function **************//

    public function mail($to, $subject, $message)
    {
        require_once '../library/PHPMailer-master/PHPMailerAutoload.php';
        $response = array(); //for response
        $data['msg'] = 'email sent';
        $mail = new PHPMailer;
        $mail->isSMTP();
		// Set mailer to use SMTP
        $mail->Host = 'premium39.web-hosting.com';             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'info@gezmed.com';          // SMTP username
        $mail->Password = 'info@9090'; // SMTP password
        $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                          // TCP port to connect to
        $mail->setFrom("info@gezmed.com");
        $mail->addReplyTo('info@gezmed.com');
        $mail->addAddress($to);
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $bodyContent = $message;
        $mail->Body = $bodyContent;
        if ($mail->send()) {
            $response = array(
                'status' => 1,
                'message' => 'Mail Successful'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Mail Not Sent'
            );
        }
        return $response;
    }


	 public function addImage($file)
	 {

		 if((isset($file['tmp_name'])) && ($file['tmp_name'] != ''))
		 {
			$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

			    if(in_array($extension, self::$image_ext))
			    {
                    $folder = "department";
                }
				else
				{
                    die(json_encode(array(
                        'status' => 0,
                        'message' => 'Invalid File Extension'
                    )));
                }

				$tempFileName = date('YmdGis') . "." . $extension;
                $uploadPath = self::$postUploadPath . "{$folder}/{$tempFileName}";

				 if(move_uploaded_file($file['tmp_name'], $uploadPath))
				{
                    return $tempFileName;
                }
				else
				{
                    throw new Exception("File Upload Problem");
                }
		 }
	 }
   }
?>
