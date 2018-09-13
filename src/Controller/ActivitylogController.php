<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Activitylog Controller
 *
 * @property \App\Model\Table\ActivitylogTable $Activitylog
 *
 * @method \App\Model\Entity\Activitylog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitylogController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
      $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
      if ( $this->request->is('post') ) {
        $postData = $this->request->input('json_decode', true);
        if( !empty( $postData ) ){
          $postData['user_id'] = $_POST['userId'];
          $postData['accessRoleIds'] = $_POST['accessRoleIds'];
        } else {
          $postData = $this->request->getData();
        }
        $saveData = array();
        if( isset( $postData['user_id'] ) && isset( $postData['post_id'] ) ){
          $wvActivity = $this->Activitylog->find('all')->where(['user_id' => $postData['user_id'], 'post_id' => $postData['post_id'] ])->toArray();
          $wvPost = $this->Activitylog->Post->get( $postData['post_id'] );
          $allowAdmin = $this->Activitylog->Post->allowAdmin( $wvPost, $postData['accessRoleIds'] );
          if( !$allowAdmin ){
            $postData['authority_flag'] = -1;
          }
          if( empty( $wvActivity ) ){
            $saveData = $postData;
            if( ( isset( $saveData['upvote'] ) ) && $saveData['upvote'] > 0 ){
              $res = $this->Activitylog->Post->changeUpvotes( $saveData['post_id'], 1 );
            }
          } else {
            $saveData = $this->Activitylog->compareAndReturn( $postData, $wvActivity[0] );
          }
          if( !empty( $saveData ) ){
            if ( $this->Activitylog->saveActivity( $saveData ) ) {
              $result = $this->Activitylog->getCumulativeResult( array( $postData['post_id'] ), $postData['user_id'] );
              $response = array( 'error' => 0, 'message' => 'Activity Submitted', 'data' => $result[ $postData['post_id'] ] );
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
     * @param string|null $id  Activitylog id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $Activitylog = $this->Activitylog->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Activitylog = $this->Activitylog->patchEntity($Activitylog, $this->request->getData());
            if ($this->Activitylog->save($Activitylog)) {
                $this->Flash->success(__('The wv activitylog has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv activitylog could not be saved. Please, try again.'));
        }
        $users = $this->Activitylog->Users->find('list', ['limit' => 200]);
        $posts = $this->Activitylog->Posts->find('list', ['limit' => 200]);
        $this->set(compact('Activitylog', 'users', 'posts'));
    }

    public function getbookmarks( ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $getData = $this->request->query();
      $postData = $this->request->getData();
      $requestData = array_merge( $getData, $postData );
      if( !isset( $requestData['userId'] ) ){
        $requestData['userId'] = $_POST['userId'];
        $requestData['accessRoleIds'] = $_POST['accessRoleIds'];
      }
      if( !isset( $requestData['mcph'] ) ){
        $requestData['mcph'] = $requestData['userId'];
      }
      if( !empty( $requestData ) && isset( $requestData['page'] ) ){
        $queryConditions = array();
        $queryConditions['page'] = $requestData['page'];
        if( isset( $requestData['offset'] ) ){
          $queryConditions['offset'] = $requestData['offset'];
        } else {
          $queryConditions['offset'] = 10;
        }
        $queryConditions['conditions'] = array( 'bookmark' => 1, 'user_id' => $requestData['mcph'] );
        $wvPost = $this->Activitylog->conditionBasedSearch( $queryConditions );
        if( !empty( $wvPost ) ){
          $response['data'] = $this->Activitylog->Post->retrievePostDetailed( $wvPost );
        } else {
          $response = array( 'error' => 0, 'message' => 'Your Feed is Empty.', 'data' => array() );
        }
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
