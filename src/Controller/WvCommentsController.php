<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvComments Controller
 *
 * @property \App\Model\Table\WvCommentsTable $WvComments
 *
 * @method \App\Model\Entity\WvComment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvCommentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Posts']
        ];
        $wvComments = $this->paginate($this->WvComments);

        $this->set(compact('wvComments'));
    }

    /**
     * View method
     *
     * @param string|null $id Wv Comment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wvComment = $this->WvComments->get($id, [
            'contain' => ['Users', 'Posts']
        ]);

        $this->set('wvComment', $wvComment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function new() {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if ( $this->request->is('post') ) {
        $postData = $this->request->input('json_decode', true);
        if( !empty( $postData ) ){
          $postData['user_id'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        $importantKeys = array( 'post_id', 'user_id', 'text');
        $saveData = array(); $continue = false;
        foreach ( $importantKeys as  $key ) {
          if( isset( $postData[ $key ] ) && ( $postData[ $key ] != '' && $postData[ $key ] != 0 ) ){
            $saveData[ $key ] = $postData[ $key ];
            $continue = true;
          } else {
            $continue = false;
            break;
          }
        }
        if ( $continue ){
          if ( $this->WvComments->newComment( $saveData ) ) {
            $response = array( 'error' => 0, 'message' => 'Comment Submitted', 'data' => array() );
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
     * @param string|null $id Wv Comment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wvComment = $this->WvComments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wvComment = $this->WvComments->patchEntity($wvComment, $this->request->getData());
            if ($this->WvComments->save($wvComment)) {
                $this->Flash->success(__('The wv comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv comment could not be saved. Please, try again.'));
        }
        $users = $this->WvComments->Users->find('list', ['limit' => 200]);
        $posts = $this->WvComments->Posts->find('list', ['limit' => 200]);
        $this->set(compact('wvComment', 'users', 'posts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wv Comment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wvComment = $this->WvComments->get($id);
        if ($this->WvComments->delete($wvComment)) {
            $this->Flash->success(__('The wv comment has been deleted.'));
        } else {
            $this->Flash->error(__('The wv comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
