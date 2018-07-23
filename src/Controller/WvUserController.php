<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\Routing\Router;
/**
 * WvUser Controller
 *
 * @property \App\Model\Table\WvUserTable $WvUser
 *
 * @method \App\Model\Entity\WvUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvUserController extends AppController {

    public $components = array('OAuth');

    /**
     * Signup API
     */
    public function signup() {
        $response = array( 'error' => 1, 'message' => '', 'data' => array() );
        $userData = array();
        $postKeys = array( 'email', 'password', 'firstName', 'lastName', 'latitude', 'longitude', 'gender', 'phone', 'certificate' );
        $postData = $this->request->input( 'json_decode', true );
        if( empty( $postData ) ){
          $postData = $this->request->data;
        }
        if ( !empty( $postData ) ){
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
            $localeRes = $this->WvUser->WvCities->WvLocalities->findLocality( $localityData );
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
            $returnId = $this->WvUser->add( $userData );
            if( $returnId ){
              $response = $this->WvUser->WvEmailVerification->add( $returnId );
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
          $user = $this->WvUser->find()->where([ 'email' => $postData['username'] ])->toArray();
          if( !empty( $user ) && $this->WvUser->checkPassword( $user[0]->password, $postData['password'] ) ){
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
               $ret = $this->WvUser->WvLoginRecord->saveLog( $userData );
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
                 $localeRes = $this->WvUser->WvCities->WvLocalities->findLocality( $localityData );
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

    public function logout(){
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

    public function getuserinfo(){
        $response = array( 'error' => 0, 'message' => '', 'data' => array() );
        $getData = $this->request->input('json_decode', true);
        if( empty( $getData ) ){
          $getData['userId'] = $_GET['userId'];
        }
        if( isset( $getData['userId'] ) && !empty( $getData['userId'] ) ){
          $data = $this->WvUser->getUserInfo( $getData['userId'] );
          $response['data'] = array_values( $data );
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }

    public function updateaccess(){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $postData = $this->request->input('json_decode', true);
      if( empty( $postData ) ){
        $postData = $this->request->data;
      }
      if( isset( $postData['userIds'] ) && isset( $postData['access'] ) && !empty( $postData['access'] ) ){
        $userData = $this->WvUser->getUserList( $postData['userIds'], array( 'id', 'access_role_ids' ) );
        $accessData = $this->WvUser->WvAccessRoles->retrieveAccessRoleIds( $postData['access']['location'], array( $postData['access']['accessLevel'] ) );
        $accessRoleIds = Hash::extract( $accessData, '{n}.id' );
        foreach( $userData as $key => $user ){
          $accessIds = json_decode( $userData[ $key ]['access_role_ids'] );
          $accessIds = array_unique( array_merge( $accessIds, $accessRoleIds ) );
          $userData[ $key ]['access_role_ids'] = json_encode( $accessIds );
        }
        $usersUpdated = $this->WvUser->updateUser( $userData );
        $userCount = count( $usersUpdated );
        if( $userCount > 0 ){
          $response = array( 'error' => 0, 'message' => $userCount.' users access have been updated.', 'data' => array() );
        } else {
          $response = array( 'error' => 0, 'message' => 'Update Failed.', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function updateuserinfo(){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $postData = $this->request->input('json_decode', true);
      if( !empty( $postData ) ){
        $postData['id'] = $_POST['userId'];
      } else {
        $postData = $this->request->data;
      }
      if( !empty( $postData ) ){
        $updatedUser = $this->WvUser->updateUser( array( $postData ) );
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

    public function emailVerification(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $postData = $this->request->input('json_decode', true);
      if( !empty( $postData ) ){
        $postData['userId'] = $_POST['userId'];
      } else {
        $postData = $this->request->getData();
      }
      if( !empty( $postData ) ){
        $countKeysPassed = 0;
        $keyChecks = array( 'userId', 'token', 'code' );
        foreach( $keyChecks as $key ){
          if( isset( $postData[ $key ] ) && !empty( $postData[ $key ] ) ){
            $countKeysPassed++;
          }
        }
        if( $countKeysPassed >= 2 ){
          $response = $this->WvUser->WvEmailVerification->verify( $postData );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    public function forgotpassword(){
      $response = array( 'error' => 1, 'message' => 'Invalid Request' );
      $postData = $this->request->input('json_decode', true);
      if( empty( $postData ) ){
        $postData = $this->request->getData();
      }
      if( !empty( $postData ) && isset( $postData['email'] ) ){
        $users = $this->WvUser->find('all')->where([ 'email' => $postData['email'] ])->toArray();
        if( $users ){
          $response = $this->WvUser->WvEmailVerification->add( $users[0]->id );
          $baseUrl = Router::fullBaseUrl().'auth/resetpassword?token='.$response->token;
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
}
