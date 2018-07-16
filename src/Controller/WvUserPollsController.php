<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvUserPolls Controller
 *
 * @property \App\Model\Table\WvUserPollsTable $WvUserPolls
 *
 * @method \App\Model\Entity\WvUserPoll[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvUserPollsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['WvUser', 'WvPoll', 'WvPost']
        ];
        $wvUserPolls = $this->paginate($this->WvUserPolls);

        $this->set(compact('wvUserPolls'));
    }

    /**
     * View method
     *
     * @param string|null $id Wv User Poll id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wvUserPoll = $this->WvUserPolls->get($id, [
            'contain' => ['WvUser', 'WvPoll', 'WvPost']
        ]);

        $this->set('wvUserPoll', $wvUserPoll);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if ( $this->request->is('post') ) {
        $postData = $this->request->input('json_decode', true);
        if( !empty( $postData ) ){
          $postData['user_id'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        if( !empty( $postData ) ){
          if( $this->WvUserPolls->saveUserPolls( $postData ) ){
            $response = array( 'error' => 0, 'message' => 'Poll Submitted', 'data' => array() );
          }
        } else {
          $response = array( 'error' => 1, 'message' => 'Error', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    /**
     * Edit method
     *
     * @param string|null $id Wv User Poll id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wvUserPoll = $this->WvUserPolls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wvUserPoll = $this->WvUserPolls->patchEntity($wvUserPoll, $this->request->getData());
            if ($this->WvUserPolls->save($wvUserPoll)) {
                $this->Flash->success(__('The wv user poll has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv user poll could not be saved. Please, try again.'));
        }
        $wvUser = $this->WvUserPolls->WvUser->find('list', ['limit' => 200]);
        $wvPoll = $this->WvUserPolls->WvPoll->find('list', ['limit' => 200]);
        $wvPost = $this->WvUserPolls->WvPost->find('list', ['limit' => 200]);
        $this->set(compact('wvUserPoll', 'wvUser', 'wvPoll', 'wvPost'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wv User Poll id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wvUserPoll = $this->WvUserPolls->get($id);
        if ($this->WvUserPolls->delete($wvUserPoll)) {
            $this->Flash->success(__('The wv user poll has been deleted.'));
        } else {
            $this->Flash->error(__('The wv user poll could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
