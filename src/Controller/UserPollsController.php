<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserPolls Controller
 *
 * @property \App\Model\Table\UserPollsTable $UserPolls
 *
 * @method \App\Model\Entity\UserPoll[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserPollsController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
      if ( $this->request->is('post') ) {
        $postData = $this->request->input('json_decode', true);
        if( !empty( $postData ) ){
          $postData['user_id'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        if( !empty( $postData ) ){
          if( $this->UserPolls->saveUserPolls( $postData ) ){
            $polls = $this->UserPolls->Polls->getPolls( array( $postData['post_id'] ), $postData['user_id'] );
            $polls = array_values( $polls );
            $response = array( 'error' => 0, 'message' => 'Poll Submitted', 'data' => $polls );
          }
        } else {
          $response = array( 'error' => 1, 'message' => 'Error', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
