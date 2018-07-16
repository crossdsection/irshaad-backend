<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvActivitylog Controller
 *
 * @property \App\Model\Table\WvActivitylogTable $WvActivitylog
 *
 * @method \App\Model\Entity\WvActivitylog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvActivitylogController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if ( $this->request->is('post') ) {
        $postData = $this->request->input('json_decode', true);
        if( !empty( $postData ) ){
          $postData['user_id'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        $saveData = array();
        if( isset( $postData['user_id'] ) && isset( $postData['post_id'] ) ){
          $wvActivity = $this->WvActivitylog->find('all')->where(['user_id' => $postData['user_id'], 'post_id' => $postData['post_id'] ])->toArray();
          if( empty( $wvActivity ) ){
            $saveData = $postData;
          } else {
            $saveData = $this->WvActivitylog->compareAndReturn( $postData, $wvActivity[0] );
          }
          if( !empty( $saveData ) ){
            if ( $this->WvActivitylog->saveActivity( $saveData ) ) {
              $response = array( 'error' => 0, 'message' => 'Activity Submitted', 'data' => array() );
            }
          } else {
            $response = array( 'error' => -1, 'message' => 'Activity Failed', 'data' => array() );
          }
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    /**
     * Edit method
     *
     * @param string|null $id Wv Activitylog id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wvActivitylog = $this->WvActivitylog->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wvActivitylog = $this->WvActivitylog->patchEntity($wvActivitylog, $this->request->getData());
            if ($this->WvActivitylog->save($wvActivitylog)) {
                $this->Flash->success(__('The wv activitylog has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv activitylog could not be saved. Please, try again.'));
        }
        $users = $this->WvActivitylog->Users->find('list', ['limit' => 200]);
        $posts = $this->WvActivitylog->Posts->find('list', ['limit' => 200]);
        $this->set(compact('wvActivitylog', 'users', 'posts'));
    }
}
