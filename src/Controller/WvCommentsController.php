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
    public function get($postId = null) {
      $postId = $this->request->getParam('postId');
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $wvComments = $this->WvComments->find('all', ['limit' => 200])->where([ 'post_id' => $postId ]);
      $fileuploadIds = array(); $userIds = array(); $data = array();
      if( !empty( $wvComments ) ){
        foreach ( $wvComments as $key => $value ) {
           $userIds[] = $value->user_id;
        }
        $userInfos = $this->WvComments->WvUser->getUserInfo( $userIds );
        foreach ( $wvComments as $key => $value ) {
          $value['user'] = $userInfos[ $value['user_id'] ];
          unset( $value['user_id'] );
          $data[] = $value;
        }
        $response['data'] = $data;
      } else {
        $response = array( 'error' => 0, 'message' => 'Invalid Param', 'data' => array() );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
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
          try {
            $saveData[ $key ] = $postData[ $key ];
            $continue = true;
          } catch (Exception $e) {
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
