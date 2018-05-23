<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../config/Database.php');
require_once('Session.php');
require_once('EmailTemplate.php');
class UserModel extends Database
{
    protected $tableName = "wv_user";
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    private $password;
    public $address;
    public $gender;
    public $latitude;
    public $longitude;
    public $profilePic;
    public $status;
    public $joindate;
    public $verify_email;
    public $google_email;
    public $google_firstName;
    public $google_latitude;
    public $google_longitude;
    public $google_address;
    public $mobileNumber;
    public $country;
    public $state;
    public $city;
    public $authority_depart_data;
    public $type_flag;
    public $authority_department_level;
    public $company_name;
    public $rwa_name;
    public $subAdminPassword;
    public $subAdminEmail;
    public $designation;
    public $uploadCertificate;
    public function __construct($flag = '', $data = '', $file = '')
    {
        parent::__construct();
        if ($flag == '') {
            if ($data != '') {
                if ((isset($data['firstName'])) && ($data['firstName'] != '')) {
                    $this->firstName = filter_var($data['firstName'], FILTER_SANITIZE_STRING);
                } else {
                    throw new Exception("First Name is required.");
                }
                if ((isset($data['lastName'])) && ($data['lastName'] != '')) {
                    $this->lastName = filter_var($data['lastName'], FILTER_SANITIZE_STRING);
                } else {
                    throw new Exception("Last Name is required.");
                }
                if ((isset($data['email'])) && ($data['email'] != '')) {
                    if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $this->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
                    } else {
                        throw new Exception("Invalid Email Address.");
                    }
                } else {
                    throw new Exception("Email is required.");
                }
                if ((isset($data['password'])) && ($data['password'] != '')) {
                    $this->password = $data['password'];
                } else {
                    throw new Exception("Password Can not be empty.");
                }
                if ((isset($data['mobileNumber'])) && ($data['mobileNumber'] != '')) {
                    $this->mobileNumber = $data['mobileNumber'];
                } else {
                    $this->mobileNumber = '';
                }
                // for super-admin
                if ((isset($data['country'])) && ($data['country'] != '')) {
                    $this->country = $data['country'];
                } else {
                    $this->mobileNumber = '';
                }
                // for super-admin
                if ((isset($data['state'])) && ($data['state'] != '')) {
                    $this->state = $data['state'];
                } else {
                    $this->state = '';
                }
                // for super-admin
                if ((isset($data['city'])) && ($data['city'] != '')) {
                    $this->city = $data['city'];
                } else {
                    $this->city = '';
                }
                // only for government type determines the level of the department.
                if ((isset($data['authority_department_level'])) && ($data['authority_department_level'] != '')) {
                    $this->authority_department_level = $data['authority_department_level'];
                } else {
                    $this->authority_department_level = '';
                }
                //type flag determines the type of sub-admin
                // for super-admin
                if ((isset($data['type_flag'])) && ($data['type_flag'] != '')) {
                    $this->type_flag = $data['type_flag'];
                } else {
                    $this->type_flag = '';
                }
                //department_level_flag determines the type of sub-admin
                // for super-admin
                if ((isset($data['department_level_flag'])) && ($data['department_level_flag'] != '')) {
                    $this->department_level_flag = $data['department_level_flag'];
                } else {
                    $this->department_level_flag = '';
                }
                //selected department option value
                // for superAdmin
                if ((isset($data['authority_depart_data'])) && ($data['authority_depart_data'] != '')) {
                    $this->authority_depart_data = $data['authority_depart_data'];
                } else {
                    $this->authority_depart_data = '';
                }
                //entered company name for media subadmin
                // for superAdmin
                if ((isset($data['company_name'])) && ($data['company_name'] != '')) {
                    $this->company_name = $data['company_name'];
                } else {
                    $this->company_name = '';
                }
                //enter rwa name for the subadmin
                // for superAdmin
                if ((isset($data['rwa_name'])) && ($data['rwa_name'] != '')) {
                    $this->rwa_name = $data['rwa_name'];
                } else {
                    $this->rwa_name = '';
                }
                if ((isset($data['user_address'])) && ($data['user_address'] != '')) {
                    $this->address = $data['user_address'];
                } else {
                    $this->address = '';
                }
                if ((isset($data['user_address_latitude'])) && ($data['user_address_latitude'] != '')) {
                    $this->latitude = $data['user_address_latitude'];
                } else {
                    $this->latitude = '';
                }
                if ((isset($data['user_address_longitude'])) && ($data['user_address_longitude'] != '')) {
                    $this->longitude = $data['user_address_longitude'];
                } else {
                    $this->longitude = '';
                }
                if ((isset($file['authority_position_certificate'])) && ($file['authority_position_certificate']['tmp_name'] != '')) {
                    $this->uploadCertificate = $file['authority_position_certificate'];
                } else {
                    $this->uploadCertificate = '';
                }
            } else {
                throw new Exception("No Data pass.");
            }
        } else if ($flag == 'id') {
            if ($data != '') {
                $userData = $this->select("*", $this->tableName, "id='{$data}'");
            } else {
                throw new Exception("Invalid Id");
            }
        }
        //verify email
        else if ($flag == 'verify') {
            if ($data != '') {
                if ((isset($data['verify_email'])) && ($data['verify_email'] != '')) {
                    $this->verify_email = $data['verify_email'];
                } else {
                    throw new Exception("Email is not correct.");
                }
            } else {
                throw new Exception("Email not pass");
            }
        } else if ($flag == 'googleLogin') {
            if ($data != '') {
                if ((isset($data['email'])) && ($data['email'] != '')) {
                    $this->google_email = $data['email'];
                    if (isset($data['firstName']) && ($data['firstName'] != '')) {
                        $this->google_firstName = $data['firstName'];
                    }
                    if (isset($data['firstName']) && ($data['firstName'] != '')) {
                        $this->google_latitude = $data['latitude'];
                    }
                    if (isset($data['firstName']) && ($data['firstName'] != '')) {
                        $this->google_longitude = $data['longitude'];
                    }
                    if (isset($data['firstName']) && ($data['firstName'] != '')) {
                        $this->google_address = $data['user_address'];
                    }
                } else {
                    throw new Exception("Email not get by Gmail.");
                }
            } else {
                throw new Exception("Email not pass");
            }
        } else if ($flag == 'verifySubAdminEmail') {
            if ($data != '') {
                if ((isset($data['email'])) && $data['email'] != '') {
                    $this->subAdminEmail = $data['email'];
                } else {
                    throw new Exception("Email id does not exists.");
                }
                if ((isset($data['password'])) && $data['password'] != '') {
                    $this->subAdminPassword = $data['password'];
                } else {
                    throw new Exception("Password is mandatory");
                }
            }
        } else if ($flag == 'profile') {
            if ($data != '') {
                if ((isset($data['id'])) && ($data['id'] != '')) {
                    $this->id = $data['id'];
                } else {
                    throw new Exception("User id is required");
                }
                if ((isset($data['firstName'])) && ($data['firstName'] != '')) {
                    $this->firstName = $data['firstName'];
                } else {
                    throw new Exception("First name is required");
                }
                if ((isset($data['lastName'])) && ($data['lastName'])) {
                    $this->lastName = $data['lastName'];
                } else {
                    throw new Exception("Last name is required");
                }
                if ((isset($data['gender'])) && ($data['gender'] != '')) {
                    $this->gender = $data['gender'];
                } else {
                    throw new Exception("Gender is required");
                }
                if ((isset($data['phone'])) && ($data['phone'] != '')) {
                    $this->phone = $data['phone'];
                } else {
                    throw new Exception("Phone is required");
                }
                if ((isset($data['email'])) && ($data['email'] != '')) {
                    $this->email = $data['email'];
                } else {
                    throw new Exception("Email is required");
                }
                if ((isset($data['country_data'])) && ($data['country_data'] != '')) {
                    $this->country = $data['country_data'];
                } else {
                    throw new Exception("Country is required");
                }
                if ((isset($data['state_data'])) && ($data['state_data'] != '')) {
                    $this->state = $data['state_data'];
                } else {
                    throw new Exception("State is required");
                }
                if ((isset($data['city_data'])) && ($data['city_data'] != '')) {
                    $this->city = $data['city_data'];
                } else {
                    throw new Exception("City is required");
                }
                if ((isset($data['designation'])) && ($data['designation'] != '')) {
                    $this->designation = $data['designation'];
                } else {
                    throw new Exception("Designation is required");
                }
            }
        } else if ($flag == 'image') {
            if ($data != '') {
                if ((isset($data['id'])) && ($data['id'] != '')) {
                    $this->id = $data['id'];
                } else {
                    throw new Exception("No user id set");
                }
                if ((isset($file['department_head_pic'])) && ($file['department_head_pic']['tmp_name'] != '')) {
                    $this->fileLink = $file['department_head_pic'];
                } else {
                    throw new Exception("No image set");
                }
            } else {
                throw new Exception("Invalid data");
            }
        }
    }
    public function userSignup()
    {
        $userdata = array(
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'password' => md5($this->password),
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'joindate' => date('Y-m-d')
        );
        $result   = $this->insert($this->tableName, $userdata);
        if ($result != false) {
            $this->id   = $this->lastInsertId();
            $verifyLink = "view/index.php?action=" . md5($this->id) . "&email=" . base64_encode($this->email);
            //$msg1=EmailTemplate::getVerifyEmailTemplate($this->firstName,$verifyLink);
            //$mail = $this->mail($this->email,'Account Verification',$msg1);
            die(json_encode(array(
                'status' => 1,
                'message' => "Registered Successfully and Verification link is send to your registered mail please verify to proceed."
            )));
        } else {
            throw new Exception("Error in adding user");
        }
    }
    public function subAdminSignup()
    {
        if ($this->type_flag != 0) {
            $image = $this->addImage($this->uploadCertificate);
        } else {
            $image = $this->uploadCertificate;
        }
        $check = $this->select("*", "wv_authority", "email = '$this->email'");
        if (count($check) === 0) {
            $subAdminData = array(
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'password' => md5($this->password),
                'phone' => $this->mobileNumber,
                'autority_role' => 1,
                'department_level_flag' => $this->authority_department_level,
                'determine_subadmin_flag' => $this->type_flag,
                'country_id' => $this->country,
                'state_id' => $this->state,
                'city_id' => $this->city,
                'department_id' => $this->authority_depart_data,
                'company_name' => $this->company_name,
                'upload_certificate' => $image,
                'rwa_name' => $this->rwa_name,
                'date_time' => date('Y-m-d')
            );
            $result       = $this->insert("wv_authority", $subAdminData);
            if ($result != false) {
                $verifyLink = "admin/verifyEmail.php?action=" . md5($this->id) . "&email=" . base64_encode($this->email);
                $msg1       = EmailTemplate::getVerifyEmailTemplate($this->firstName, $verifyLink);
                $mail       = $this->mail($this->email, 'Account Verification', $msg1);
                die(json_encode(array(
                    'status' => 1,
                    'message' => "Registered Successfully and verification Link is sent on your email."
                )));
            } else {
                throw new Exception("Error in adding user");
            }
        } else {
            die(json_encode(array(
                'status' => 1,
                'message' => "Already Registered."
            )));
        }
    }
    public function verifySubAdminEmail()
    {
        $check = $this->select("*", "wv_authority", "email = '$this->subAdminEmail'");
        $data  = $check[0];
        if ($data['password'] == md5($this->subAdminPassword)) {
            $updata_subAdmin = $this->update("wv_authority", array(
                'email_verify' => 1
            ), "email = '$this->subAdminEmail'");
            if ($updata_subAdmin != false) {
                die(json_encode(array(
                    'status' => 1,
                    'message' => "Email Verified Success"
                )));
            }
        } else {
            die(json_encode(array(
                'status' => 0,
                'message' => "Password Doesn't match"
            )));
        }
    }
    public function verifyEmail()
    {
        $emailData = $this->select("email", $this->tableName, "email= '{$this->verify_email}'");
        if (count($emailData)) {
            $emailData = $emailData[0];
            if ($emailData['email'] == $this->verify_email) {
                $result = $this->update($this->tableName, array(
                    'email_verified' => 1
                ), "email='$this->verify_email'");
                if ($result != false) {
                    die(json_encode(array(
                        'status' => 1,
                        'message' => "Email verification has been done successfully, please login now."
                    )));
                } else {
                    throw new Exception("Error in verification email");
                }
            } else {
                throw new Exception("Invalid Email");
            }
        } else {
            throw new Exception("Email does not exist");
        }
    }
    public function gmailLogin()
    {
        $check = $this->select("*", $this->tableName, "email= '{$this->google_email}'");
        if (count($check) > 0) {
            $updateOnlineStatus = $this->update($this->tableName, array(
                'active' => 1,
                'email_verified' => 1
            ), "id= '{$check[0]['id']}'");
            $details            = array(
                'user_id' => $check[0]['id'],
                'latitude' => $this->google_latitude,
                'longitude' => $this->google_longitude
            );
            $checkLoginRecord   = $this->select("*", "wv_login_record", "wv_login_record.user_id = '{$check[0]['id']}' and wv_login_record.latitude = '{$this->google_latitude}' and wv_login_record.longitude = '{$this->google_longitude}' ");
            if (count($checkLoginRecord) > 0) {
            } else {
                $insertLoginRecord = $this->insert("wv_login_record", $details);
            }
            $session          = new Session(array(
                'id' => $check[0]['id'],
                'firstName' => $check[0]['firstname'],
                'lastName' => $check[0]['lastname'],
                'gender' => $check[0]['gender'],
                'email' => $check[0]['email'],
                'phone' => $check[0]['phone'],
                'address' => $check[0]['address'],
                'profile' => $check[0]['profilepic']
            ));
            $_SESSION['user'] = serialize($session);
            die(json_encode(array(
                'status' => 1,
                'message' => "Login Successfully"
            )));
        } else {
            $userdata = array(
                'firstname' => $this->google_firstName,
                'email' => $this->google_email,
                'address' => $this->google_address,
                'latitude' => $this->google_latitude,
                'longitude' => $this->google_longitude,
                'joindate' => date('Y-m-d')
            );
            $result   = $this->insert($this->tableName, $userdata);
            if ($result != false) {
                $this->id         = $this->lastInsertId();
                $session          = new Session(array(
                    'id' => $this->id,
                    'firstName' => $this->google_firstName,
                    'email' => $this->email,
                    'address' => $this->address
                ));
                $_SESSION['user'] = serialize($session);
                die(json_encode(array(
                    'status' => 1,
                    'message' => "Login Successfully"
                )));
                die(json_encode(array(
                    'status' => 1,
                    'message' => "Registered Successfully and Verification link is send to your registered mail please verify to proceed."
                )));
            } else {
                throw new Exception("Error in adding user");
            }
        }
    }
    public function subadminProfileSetting()
    {
        $details       = array(
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'email' => $this->email,
            'country_id' => $this->country,
            'state_id' => $this->state,
            'city_id' => $this->city,
            'designation' => $this->designation
        );
        $updateProfile = $this->update("wv_authority", $details, "wv_authority.id = '{$this->id}'");
        if ($updateProfile != false) {
            die(json_encode(array(
                'status' => 1,
                'message' => "Profile is updated successfully"
            )));
        } else {
            die(json_encode(array(
                'status' => 0,
                'message' => "Error in profile updation."
            )));
        }
    }
    public function changeProfileImage()
    {
        $image           = $this->addImage($this->fileLink);
        $getSubadminData = $this->select("wv_authority.department_id", "wv_authority", "wv_authority.id= '{$this->id}'");
        var_dump($getSubadminData);
        exit;
        if (count($getSubadminData) > 0) {
            $getSubadminData = $getSubadminData[0];
            if ($getSubadminData['department_id'] != '0') {
                //;
                $getDepartmentHeadImage = $this->select("wv_ministry.ministry_head_profilepic", "wv_ministry", "wv_ministry.id = '{$getSubadminData['department_id']}'");
                //print_r($getDepartmentHeadImage);
                if (count($getDepartmentHeadImage) > 0) {
                    $getDepartmentHeadImage = $getDepartmentHeadImage[0];
                    if ($getDepartmentHeadImage['ministry_head_profilepic'] != '') {
                        unlink('../assets/images/department/' . $getDepartmentHeadImage['ministry_head_profilepic']);
                    }
                }
                $updateDepartmentHeadImage = $this->update('wv_ministry', array(
                    'ministry_head_profilepic' => $image
                ), "wv_ministry.id = '{$getSubadminData['department_id']}'");
            }
        }
        $updateSubadminProfile = $this->update("wv_authority", array(
            'profile_picture' => $image
        ), "wv_authority.id = '{$this->id}'");
        if ($updateSubadminProfile != false) {
            die(json_encode(array(
                'status' => 1,
                'message' => 'Image updated successfully'
            )));
        } else {
            die(json_encode(array(
                'status' => 0,
                'message' => 'Error in image updation'
            )));
        }
    }
}
?>
