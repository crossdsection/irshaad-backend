<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id  Comment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function get($postId = null) {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $postId = $this->request->query('postId');
      $parentId = $this->request->query('parentId');
      if( !$parentId ){
        $parentId = 0;
      }
      $wvComments = $this->Comments->find('all', [
        'limit' => 200,
        'fields' => array( 'id', 'user_id', 'post_id', 'text', 'created', 'modified', 'parent_id' ) ])->where([ 'post_id' => $postId, 'parent_id' => $parentId ]);
      $fileuploadIds = array(); $userIds = array(); $commentIds = array(); $data = array();
      if( !empty( $wvComments ) ){
        foreach ( $wvComments as $key => $value ) {
           $userIds[] = $value->user_id;
           $commentIds[] = $value->id;
        }
        $userInfos = $this->Comments->User->getUserInfo( $userIds );
        $parentCounts = $this->Comments->getReplyCounts( $commentIds );
        $parentCounts = Hash::combine( $parentCounts, '{n}.parent_id', '{n}.count' );
        foreach ( $wvComments as $key => $value ) {
          if( isset( $parentCounts[ $value['id'] ] ) ){
            $value['replyCounts'] = $parentCounts[ $value['id'] ];
          } else {
            $value['replyCounts'] = 0;
          }
          unset( $userInfos[ $value['user_id'] ]['accessRoles'] );
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
          if( isset( $postData[ $key ] ) ){
            $saveData[ $key ] = $postData[ $key ];
            $continue = true;
          } else {
            $continue = false;
            break;
          }
        }
        if( isset( $postData['parent_id'] ) ){
          $saveData['parent_id'] = $postData['parent_id'];
        }
        if ( $continue ){
          if ( $this->Comments->newComment( $saveData ) ) {
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
}
