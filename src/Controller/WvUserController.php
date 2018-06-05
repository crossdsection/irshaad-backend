<?php
namespace App\Controller;

use App\Controller\AppController;

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
        if ( !empty( $this->request->data ) ){
          foreach( $postKeys as $postKey ){
            if( isset( $this->request->data[ $postKey ] ) && !empty( $this->request->data[ $postKey ] ) ){
              $newKey = strtolower( $postKey );
              if( $postKey == 'certificate' ){
                $file = $this->request->data[ $postKey ];
                $filePath = 'img' . DS . 'upload' . DS . $file['name'];
                $fileUrl = WWW_ROOT . $filePath;
                if( move_uploaded_file( $file['tmp_name'], $fileUrl ) ){
                  $userData[ $newKey ] = $filePath;
                }
              } else {
                $userData[ $newKey ] = $this->request->data[ $postKey ];
              }
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
        $user = $this->WvUser->find()->where([ 'email' => $_POST['username'] ])->toArray();
        if( $this->WvUser->checkPassword( $user[0]->password, $_POST['password'] ) ){
          $res = $this->OAuth->getAccessToken( $user[0]->id );
          if( $res['error'] == 0 ){
             $latitude = 0;
             $longitude = 0;
             if( isset( $_POST['latitude'] ) && $_POST['latitude'] != 0 ){
               $latitude = $_POST['latitude'];
             }
             if( isset( $_POST['longitude'] ) && $_POST['latitude'] != 0 ){
               $longitude = $_POST['longitude'];
             }
             $userData = array(
               'user_id'  => $user[0]->id,
               'latitude' => $latitude,
               'longitude'=> $longitude
             );
             $ret = $this->WvUser->WvLoginRecord->saveLog( $userData );
          }
          $response = array( 'error' => $res['error'], 'message' => $res['message'], 'data' => $res['data'] );
        } else {
          $response = array( 'error' => 1, 'message' => 'Invalid Login', 'data' => array() );
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }

    public function getuserinfo(){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( isset( $_POST['userId'] ) && !empty( $_POST['userId'] ) ){
        $user = $this->WvUser->find()->where([ 'id' => $_POST['userId'], 'status' => 1 ])->toArray();
        $tmpResponse = array();
        if( isset( $user[0]['firstname'] ) && isset( $user[0]['lastname'] ) ){
          $tmpResponse['name'] = $user[0]['firstname'].' '.$user[0]['lastname'];
        }
        $directKeys = array( 'gender', 'email', 'phone', 'address', 'latitude', 'longitude' );
        foreach( $directKeys as $key ){
          if( isset( $user[0][ $key ] ) ){
            $tmpResponse[ $key ] = $user[0][ $key ];
          }
        }
        if( isset( $user[0]['access_role_ids'] ) ){
          $accessRoles = $this->WvUser->WvAccessRoles->getAccessData( json_decode( $user[0]['access_role_ids'] ) );
          $tmpResponse[ 'accessRoles' ] = $accessRoles;
        }
        $response['data'] = $tmpResponse;
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
