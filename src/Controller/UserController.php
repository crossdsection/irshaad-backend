<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\Routing\Router;
/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController {

    public $components = array('OAuth', 'Files');

    public function userexists(){
      $response = array( 'error' => 1, 'message' => '', 'data' => array() );
      $getData = $this->request->query();
      if( isset( $getData['email'] ) && $this->User->checkEmailExist( $getData['email'] ) ){
        $response = array( 'error' => 0, 'message' => 'User Exists', 'data' => array( 'exist' => true, 'notExist' => false ) );
      } else {
        $response = array( 'error' => 0, 'message' => 'User Does not Exists', 'data' => array( 'exist' => false, 'notExist' => true ) );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    /**
     * Signup API
     */
    public function signup() {
        $response = array( 'error' => 1, 'message' => '', 'data' => array() );
        $userData = array(); $continue = false;
        $postKeys = array( 'email', 'password', 'firstName', 'lastName', 'latitude', 'longitude', 'gender', 'phone', 'certificate' );
        $postData = $this->request->input( 'json_decode', true );
        if( empty( $postData ) ){
          $postData = $this->request->data;
        }
        if( isset( $postData['email'] ) && !$this->User->checkEmailExist( $postData['email'] ) ){
          $continue = true;
        }
        if ( !empty( $postData ) && $continue ){
          foreach( $postKeys as $postKey ){
            if( isset( $postData[ $postKey ] ) && !empty( $postData[ $postKey ] ) ){
              $newKey = strtolower( $postKey );
              if( $postKey == 'certificate' ){
                $file = $postData[ $postKey ];
                $filePath = 'img' . DS . 'upload' . DS . $file['name'];
                $fileUrl = WWW_ROOT . $filePath;
                if( move_uploaded_file( $file['tmp_name'], $fileUrl ) ){
                  $userData[ $newKey ] = $filePath;
                }
              } else {
                $userData[ $newKey ] = $postData[ $postKey ];
              }
            }
          }
          if( isset( $postData['birthDate'] ) ){
            $userData['date_of_birth'] = date( 'Y-m-d', strtotime( $postData['birthDate'] ) );
          }
          $localityCheck = false;
          $localityCheckArray = array( 'locality', 'city', 'latitude', 'longitude', 'state', 'country' );
          $localityData = array();
          foreach ( $localityCheckArray as $key => $value ) {
            if( isset( $postData[ $value ] ) && ( $postData[ $value ] != '' or $postData[ $value ] != 0 ) ){
              $localityData[ $value ] = $postData[ $value ];
              $localityCheck = true;
            } else {
              $localityCheck = false;
              break;
            }
          }
          if( $localityCheck ){
            $localeRes = $this->User->Cities->Localities->findLocality( $localityData );
            if( $localeRes['error'] == 0 ){
              foreach ( $localeRes['data'] as $key => $locale ) {
                if( isset( $locale[0] ) && isset( $locale[0]['city_id'] ) )
                 $userData['city_id'] = $locale[0]['city_id'];
                if( isset( $locale[0] ) && isset( $locale[0]['state_id'] ) )
                 $userData['state_id'] = $locale[0]['state_id'];
                if( isset( $locale[0] ) && isset( $locale[0]['country_id'] ) )
                 $userData['country_id'] = $locale[0]['country_id'];
              }
              $res['data']['locale'] = $localeRes['data'];
            }
          }
          if( !empty( $userData ) ){
            $returnId = $this->User->add( $userData );
            if( $returnId ){
              $response = $this->User->EmailVerification->add( $returnId );
              $baseUrl = Router::fullBaseUrl().'email/verify?token='.$response->token;
              $emailData = array( 'action_url' => $baseUrl, 'code' => $response->code );
              $result = $this->_sendMail( array( $userData['email'] ), 'Verification Email', 'emailVerification', $emailData );
              $response = array( 'error' => 0, 'message' => 'Registration Successful', 'data' => array() );
            } else {
              $response = array( 'error' => 1, 'message' => 'Registration Failed', 'data' => array() );
            }
          } else {
            $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
          }
        } else {
          $response = array( 'error' => 1, 'message' => 'Registration Failed', 'data' => array() );
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }

    /**
     * Login API
     */
    public function login() {
        $response = array( 'error' => 0, 'message' => '', 'data' => array() );
        $postData = $this->request->input('json_decode', true);
        if( empty( $postData ) ){
          $postData = $this->request->data;
        }
        if( isset( $postData['username'] ) && isset( $postData['password'] ) ){
          $user = $this->User->find()->where([ 'email' => $postData['username'] ])->toArray();
          if( !empty( $user ) && $this->User->checkPassword( $user[0]->password, $postData['password'] ) ){
            $res = $this->OAuth->getAccessToken( $user[0]->id );
            if( $res['error'] == 0 ){
               $latitude = 0;
               $longitude = 0;
               if( isset( $postData['latitude'] ) && $postData['latitude'] != 0 ){
                 $latitude = $postData['latitude'];
               }
               if( isset( $postData['longitude'] ) && $postData['latitude'] != 0 ){
                 $longitude = $postData['longitude'];
               }
               $userData = array(
                 'user_id'  => $user[0]->id,
                 'latitude' => $latitude,
                 'longitude'=> $longitude
               );
               $ret = $this->User->LoginRecord->saveLog( $userData );
               $localityCheck = false;
               $localityCheckArray = array( 'locality', 'city', 'latitude', 'longitude', 'state', 'country' );
               $localityData = array();
               foreach ( $localityCheckArray as $key => $value ) {
                 if( isset( $postData[ $value ] ) && ( $postData[ $value ] != '' or $postData[ $value ] != 0 ) ){
                   $localityData[ $value ] = $postData[ $value ];
                   $localityCheck = true;
                 } else {
                   $localityCheck = false;
                   break;
                 }
               }
               if( $localityCheck ){
                 $localeRes = $this->User->Cities->Localities->findLocality( $localityData );
                 if( $localeRes['error'] == 0 ){
                   foreach ( $localeRes['data'] as $key => $locale ) {
                     if( isset( $locale[0] ) && isset( $locale[0]['city_id'] ) )
                      $userData['city_id'] = $locale[0]['city_id'];
                     if( isset( $locale[0] ) && isset( $locale[0]['state_id'] ) )
                      $userData['state_id'] = $locale[0]['state_id'];
                     if( isset( $locale[0] ) && isset( $locale[0]['country_id'] ) )
                      $userData['country_id'] = $locale[0]['country_id'];
                   }
                   $res['data']['locale'] = $localeRes['data'];
                 }
               }
            }
            $response = array( 'error' => $res['error'], 'message' => $res['message'], 'data' => $res['data'] );
          } else {
            $response = array( 'error' => 1, 'message' => 'Invalid Login', 'data' => array() );
          }
        } else {
          $response = array( 'error' => 1, 'message' => 'Invalid Login', 'data' => array() );
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }

    public function logout() {
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $userId = null;
      if( isset( $_GET['userId'] ) ){
        $userId = $_GET['userId'];
      }
      if( $userId != null ){
        $response = $this->OAuth->removeToken( $userId );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function getuserinfo() {
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $jsonData = $this->request->input('json_decode', true);
      $getData = $this->request->query();
      $postData = $this->request->getData();
      $requestData = array_merge( $getData, $postData );
      if( $jsonData )
        $requestData = array_merge( $requestData, $jsonData );
      if( !isset( $requestData['userId'] ) ){
        $requestData['userId'] = $_POST['userId'];
        $requestData['accessRoleIds'] = $_POST['accessRoleIds'];
      }
      if( !isset( $requestData['mcph'] ) ){
        $requestData['mcph'] = $requestData['userId'];
      }
      if( !empty( $requestData ) ){
        $data = $this->User->getUserInfo( array( $requestData['mcph'] ) );
        if( !empty( $data ) ){
          if( $requestData['mcph'] != $requestData['userId'] ){
            $data[ $requestData['mcph'] ]['editable'] = false;
          } else {
            $data[ $requestData['mcph'] ]['editable'] = true;
          }
          $response = array( 'error' => 0, 'message' => 'Success!', 'data' => array_values( $data ) );
        } else {
          $response = array( 'error' => 0, 'message' => 'User Not Found', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function updateaccess() {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $postData = $this->request->input('json_decode', true);
      if( !empty( $postData ) ){
        $postData['userId'] = $_POST['userId'];
        $postData['accessRoleIds'] = $_POST['accessRoleIds'];
      } else {
        $postData = $this->request->getData();
      }
      if( isset( $postData['userIds'] ) && isset( $postData['access'] ) && !empty( $postData['access'] ) ){
        $userData = $this->User->getUserList( $postData['userIds'], array( 'id', 'access_role_ids' ) );
        $accessData = $this->User->AccessRoles->retrieveAccessRoleIds( $postData['access']['location'], array( $postData['access']['accessLevel'] ) );
        $accessRoleIds = Hash::extract( $accessData, '{n}.id' );
        $accessRoleIds = array_intersect( $accessRoleIds, $postData['accessRoleIds'] );
        if( !empty( $accessRoleIds ) ){
          foreach( $userData as $key => $user ){
            $accessIds = json_decode( $userData[ $key ]['access_role_ids'] );
            $accessIds = array_unique( array_merge( $accessIds, $accessRoleIds ) );
            $userData[ $key ]['access_role_ids'] = json_encode( $accessIds );
          }
          $usersUpdated = $this->User->updateUser( $userData );
          $userCount = count( $usersUpdated );
          if( $userCount > 0 ){
            $response = array( 'error' => 0, 'message' => $userCount.' users access have been updated.', 'data' => array() );
          } else {
            $response = array( 'error' => 0, 'message' => 'Update Failed.', 'data' => array() );
          }
        } else {
          $response = array( 'error' => 0, 'message' => 'Forbidden Access.', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function updateuserinfo() {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $postData = $this->request->input('json_decode', true);
      if( !empty( $postData ) ){
        $postData['id'] = $_POST['userId'];
      } else {
        $postData = $this->request->data;
      }
      if( !empty( $postData ) ){
        $updatedUser = $this->User->updateUser( array( $postData ) );
        $userCount = count( $updatedUser );
        if( $userCount > 0 ){
          $response = array( 'error' => 0, 'message' => 'User has been updated.', 'data' => array() );
        } else {
          $response = array( 'error' => 0, 'message' => 'Update Failed.', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function emailVerification() {
      $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
      $postData = $this->request->input('json_decode', true);
      if( empty( $postData ) ){
        $postData = $this->request->getData();
      }
      if( !empty( $postData ) ){
        $countKeysPassed = 0;
        $keyChecks = array( 'email', 'token', 'code' );
        foreach( $keyChecks as $key ){
          if( isset( $postData[ $key ] ) && !empty( $postData[ $key ] ) ){
            $countKeysPassed++;
          }
        }
        if( $countKeysPassed >= 2 ){
          $response = $this->User->EmailVerification->verify( $postData );
          if( $response['error'] == 0 ){
            $res = $this->OAuth->getAccessToken( $response['data'][0] );
            $response['data'] = $res['data'];
          }
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function forgotpassword() {
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $postData = $this->request->input('json_decode', true);
      if( empty( $postData ) ){
        $postData = $this->request->getData();
      }
      if( !empty( $postData ) && isset( $postData['email'] ) ){
        $users = $this->User->find('all')->where([ 'email' => $postData['email'] ])->toArray();
        if( $users ){
          $response = $this->User->EmailVerification->add( $users[0]->id );
          $baseUrl = Router::fullBaseUrl().'resetpassword?email='.$postData['email'].'&token='.$response->token;
          $emailData = array( 'action_url' => $baseUrl, 'code' => $response->code );
          $result = $this->_sendMail( array( $postData['email'] ), 'Reset Password', 'forgotPassword', $emailData );
          $response = array( 'error' => 0, 'message' => 'Reset Code Sent' );
        } else {
          $response = array( 'error' => 1, 'message' => 'User Not Found' );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function changeProfilePicture(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
      if ($this->request->is('post')) {
        $userId = null;
        if( isset( $_POST['userId'] ) ){
          $userId = $_POST['userId'];
        }
        $userData = array( $userId => array( 'id' => $userId ) );
        if( !empty( $this->request->getData('profile') ) ){
          $result = $this->Files->saveFile( $this->request->getData('profile') );
          if( $result ){
            $userData[ $userId ] = array( 'id' => $userId, 'profilepic' => $result['filepath'] );
          }
          $usersUpdated = $this->User->updateUser( $userData );
          if ( !empty( $usersUpdated ) ) {
            $response = array( 'error' => 0, 'message' => 'Profile Pic Changed', 'data' => array( 'profilepic' => $userData[ $userId ] ) );
          } else {
            $response = array( 'error' => 1, 'message' => 'Error', 'data' => array() );
          }
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function follow(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $postData = $this->request->input('json_decode', true);
      if( !empty( $postData ) ){
        $postData['userId'] = $_POST['userId'];
        $postData['accessRoleIds'] = $_POST['accessRoleIds'];
      } else {
        $postData = $this->request->getData();
      }
      if( !empty( $postData ) && isset( $postData['mcph'] ) ){
        $data = array( 'user_id' => $postData['userId'], 'followuser_id' => $postData['mcph'] );
        if( $this->User->UserFollowers->follow( $data ) ){
          $response = array( 'error' => 0, 'message' => 'Follow Successful.' );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function unfollow(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $postData = $this->request->input('json_decode', true);
      if( !empty( $postData ) ){
        $postData['userId'] = $_POST['userId'];
        $postData['accessRoleIds'] = $_POST['accessRoleIds'];
      } else {
        $postData = $this->request->getData();
      }
      if( !empty( $postData ) && isset( $postData['mcph'] ) ){
        $data = array( 'user_id' => $postData['userId'], 'followuser_id' => $postData['mcph'] );
        if( $this->User->UserFollowers->unfollow( $data ) ){
          $response = array( 'error' => 0, 'message' => 'Follow Successful.' );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function getFollowers(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
      $jsonData = $this->request->input('json_decode', true);
      $getData = $this->request->query();
      $postData = $this->request->getData();
      $requestData = array_merge( $getData, $postData );
      if( $jsonData )
        $requestData = array_merge( $requestData, $jsonData );
      if( !isset( $requestData['user_id'] ) ){
        $requestData['user_id'] = $_POST['userId'];
      }
      if( !isset( $requestData['mcph'] ) ){
        $requestData['mcph'] = $requestData['user_id'];
      }
      if( !empty( $requestData ) && isset( $requestData['page'] )){
        $searchText = null;
        if( isset( $requestData['searchKey'] ) ){
          $searchText = $requestData['searchKey'];
        }
        $mcphData = $this->User->UserFollowers->getfollowers( $requestData['mcph'], $searchText )['data'];
        $userData = $this->User->UserFollowers->getfollowing( $requestData['user_id'], $searchText )['data'];
        $returnData = $this->User->UserFollowers->compareFollowStatus( $userData, $mcphData );
        $response = array( 'error' => 0, 'message' => '', 'data' => $returnData );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function getFollowings(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
      $jsonData = $this->request->input('json_decode', true);
      $getData = $this->request->query();
      $postData = $this->request->getData();
      $requestData = array_merge( $getData, $postData );
      if( $jsonData )
        $requestData = array_merge( $requestData, $jsonData );
      if( !isset( $requestData['user_id'] ) ){
        $requestData['user_id'] = $_POST['userId'];
      }
      if( !isset( $requestData['mcph'] ) ){
        $requestData['mcph'] = $requestData['user_id'];
      }
      if( !empty( $requestData ) && isset( $requestData['page'] ) ){
        $searchText = null; $queryConditions = array();
        $queryConditions['page'] = $requestData['page'];
        if( isset( $requestData['offset'] ) ){
          $queryConditions['offset'] = $requestData['offset'];
        }
        if( isset( $requestData['searchKey'] ) ){
          $searchText = $requestData['searchKey'];
        }
        $mcphData = $this->User->UserFollowers->getfollowing( $requestData['mcph'], $searchText )['data'];
        $userData = $this->User->UserFollowers->getfollowing( $requestData['user_id'], $searchText )['data'];
        $returnData = $this->User->UserFollowers->compareFollowStatus( $userData, $mcphData );
        $response = array( 'error' => 0, 'message' => '', 'data' => $returnData );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
