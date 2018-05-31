<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * OAuth component
 */
class OAuthComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getAccessToken( $userId = 0 ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( $userId != 0 ){
        $this->Oauth = TableRegistry::get('WvOauth');
        $result = $this->Oauth->getUserToken( $userId );
        if( $result['error'] != 1 ){
          $response['message'] = 'Access Token Generated';
          $response['data'] = $result['data'];
        } else {
          $result = $this->Oauth->createUserToken( $userId );
          if( $result['error'] != 1 ){
            $response['message'] = 'Access Token Generated';
            $response['data'] = $result['data'];
          } else {
            $response['message'] = 'Failed! Please Try Again.';
          }
        }
      }
      return $response;
    }
}
