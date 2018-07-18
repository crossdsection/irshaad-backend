<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

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
        $postKeys = array('email', 'password','firstName','lastName','latitude','longitude','gender','phone','certificate');
        $postData = $this->request->input('json_decode', true);
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
          if( !empty( $userData ) && $this->WvUser->add( $userData ) ){
            $response = array( 'error' => 0, 'message' => 'Registration Successful', 'data' => array() );
          } else {
            $response = array( 'error' => 1, 'message' => 'Registration Failed', 'data' => array() );
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
        $accessData = $this->WvUser->WvAccessRoles->retrieveAccessRoleIds( $postData['access']['location'], $postData['access']['accessLevel'] );
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
      if( empty( $postData ) ){
        $postData = $this->request->data;
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
