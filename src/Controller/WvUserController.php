<?php
namespace App\Controller;

use App\Controller\AppController;
use Firebase\JWT\JWT;

/**
 * WvUser Controller
 *
 * @property \App\Model\Table\WvUserTable $WvUser
 *
 * @method \App\Model\Entity\WvUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvUserController extends AppController
{
    /**
     * Signup API
     */
    public function signup() {
        $response = array( 'error' => 1, 'message' => '', 'data' => array() );
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
        if( $user[0]->password == md5( $_POST['password'] ) ){
          $response = array( 'error' => 0, 'message' => 'Login Successful', 'data' => $user );
        } else {
          $response = array( 'error' => 1, 'message' => 'Invalid Login', 'data' => array() );
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }
}
