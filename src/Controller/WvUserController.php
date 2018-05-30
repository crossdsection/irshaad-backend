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
        $response = array( 'error' => 1, 'message' => '', 'data' => array() );
        $user = $this->WvUser->find()->where([ 'email' => $_POST['username'] ])->toArray();
        if( $this->WvUser->checkPassword( $user[0]->password, $_POST['password'] ) ){
          $response = $this->OAuth->getAccessToken( $user[0]->id );
          $response = array( 'error' => 0, 'message' => 'Login Successful', 'data' => $response );
        } else {
          $response = array( 'error' => 1, 'message' => 'Invalid Login', 'data' => array() );
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }
}
