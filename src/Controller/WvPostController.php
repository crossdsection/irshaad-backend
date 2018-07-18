<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
/**
 * WvPost Controller
 *
 * @property \App\Model\Table\WvPostTable $WvPost
 *
 * @method \App\Model\Entity\WvPost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvPostController extends AppController
{

    public $components = array('ArrayGroup');

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
          $postData['userId'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        $saveData = array(); $continue = false;
        $importantKeys = array( 'department_id', 'country_id', 'state_id', 'city_id', 'locality_id' );
        foreach( $importantKeys as $key ){
          if( isset( $postData[ $key ] ) && !empty( $postData[ $key ] ) ){
            $saveData[ $key ] = $postData[ $key ];
            $continue = true;
          } else {
            $saveData[ $key ] = 0;
          }
        }
        if( isset( $postData[ 'title' ] ) && !empty( $postData[ 'title' ] ) ){
          $saveData[ 'title' ] = $postData[ 'title' ];
        } else {
          $continue = false;
        }
        if( isset( $postData[ 'userId' ] ) && !empty( $postData[ 'userId' ] ) ){
          $saveData[ 'user_id' ] = $postData[ 'userId' ];
          $tmp = $this->WvPost->WvUser->WvLoginRecord->getLastLogin( $postData[ 'userId' ] );
          $saveData[ 'latitude' ] = $tmp[ 'latitude' ];
          $saveData[ 'longitude' ] = $tmp[ 'longitude' ];
        } else {
          $continue = false;
        }
        if( isset( $postData[ 'details' ] ) && !empty( $postData[ 'details' ] ) ){
          $saveData[ 'details' ] = $postData[ 'details' ];
        }
        if( isset( $postData[ 'postType' ] ) && !empty( $postData[ 'postType' ] ) ){
          $saveData[ 'post_type' ] = $postData[ 'postType' ];
          if( $postData[ 'postType' ] == 'court' && !isset( $postData['polls'] ) ){
            $continue = false;
          }
        }
        if( !empty( $postData[ 'filejson' ] ) ){
          $saveData[ 'filejson' ] = json_encode( $postData[ 'filejson' ] );
        }
        if ( $continue ){
          $returnId = $this->WvPost->savePost( $saveData );
          if ( $returnId ) {
            if( $saveData[ 'post_type' ] == 'court' ){
              $data = array( 'post_id' => $returnId, 'polls' => $postData['polls'] );
              $return = $this->WvPost->WvPolls->savePolls( $data );
            }
            $response = array( 'error' => 0, 'message' => 'Post Submitted', 'data' => array() );
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
     * Feed method
     *
     * @param string|null $id Wv Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function getpost( $id = null )
    {
      $id = $this->request->getParam('id');
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $wvPost = $this->WvPost->find('all')->where(['id' => $id]);
      $fileuploadIds = array(); $userIds = array(); $data = array();
      if( !empty( $wvPost ) ){
        foreach ( $wvPost as $key => $value ) {
           $fileuploadIds = array_merge( $fileuploadIds, json_decode( $value['filejson'] ) );
           $userIds[] = $value->user_id;
        }
        $this->WvFileuploads = TableRegistry::get('WvFileuploads');
        $fileResponse = $this->WvFileuploads->getfileurls( $fileuploadIds );
        $userInfos = $this->WvPost->WvUser->getUserInfo( $userIds );
        $postProperties = $this->WvPost->WvActivitylog->getProperties( $id );
        foreach ( $wvPost as $key => $value ) {
          if( !empty( $fileResponse['data']  ) ){
            $fileJSON = json_decode( $value->filejson );
            $value['files'] = array();
            foreach( $fileJSON as $key => $id ){
              if( isset( $fileResponse['data'][ $id ] ) ){
                $value['files'][] = $fileResponse['data'][ $id ];
              }
            }
          }
          $value['props'] = $postProperties;
          unset( $value['filejson'] );
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
     * GetFeed method
     *
     * @param string|null $id Wv Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function getfeed($id = null)
    {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $data = array( 'discussion' => array(), 'court' => array(), 'news' => array() );
      $wvPost = $this->WvPost->find('all', ['limit' => 200]);
      $fileuploadIds = array(); $userIds = array(); $postIds = array();
      $localityIds = array(); $localityCityMap = array();
      if( !empty( $wvPost ) ){
        $accessRoleIds = array();
        if( isset( $_POST['accessRoleIds'] ) )
          $accessRoleIds = $_POST['accessRoleIds'];
        $locationTag = array( 'city_id' => array(), 'state_id' => array(), 'country_id' => array());
        foreach ( $wvPost as $key => $value ) {
          $fileuploadIds = array_merge( $fileuploadIds, json_decode( $value['filejson'] ) );
          $userIds[] = $value->user_id;
          $postIds[] = $value->id;
          if( $value->locality_id != 0 )
            $localityIds[] = $value->locality_id;
          if( $value->city_id != 0 )
            $locationTag['city_id'][] = $value->city_id;
          if( $value->state_id != 0 )
            $locationTag['state_id'][] = $value->state_id;
          if( $value->country_id != 0 )
            $locationTag['country_id'][] = $value->country_id;
        }
        $this->WvFileuploads = TableRegistry::get('WvFileuploads');
        $fileResponse = $this->WvFileuploads->getfileurls( $fileuploadIds );
        $userInfos = $this->WvPost->WvUser->getUserList( $userIds );
        $postProperties = $this->WvPost->WvActivitylog->getCumulativeResult( $postIds );
        $postPolls = $this->WvPost->WvPolls->getPolls( $postIds );
        if( !empty( $localityIds ) ){
          $localityRes = $this->WvPost->WvLocalities->findLocalityById( $localityIds );
          if( !empty( $localityRes['data']['cities'] )){
            $localityCityMap = Hash::combine( $localityRes['data']['localities'], '{n}.locality_id', '{n}.city_id' );
            $cityIds = Hash::extract( $localityRes['data']['cities'], '{n}.city_id' );
            $locationTag['city_id'] = array_merge( $cityIds, $locationTag['city_id'] );
          }
        }
        if( !empty( $locationTag['city_id'] ) || !empty( $locationTag['state_id'] ) || !empty( $locationTag['country_id'] ) ){
          $locationTag['city_id'] = array_unique( $locationTag['city_id'] );
          $locationTag['state_id'] = array_unique( $locationTag['state_id'] );
          $locationTag['country_id'] = array_unique( $locationTag['country_id'] );
          $accessData = $this->WvPost->WvUser->WvAccessRoles->retrieveAccessRoleIds( $locationTag );
          $accessData = $this->ArrayGroup->array_group_by( $accessData, 'area_level', 'area_level_id');
        }
        foreach ( $wvPost as $key => $value ) {
          $accessRoleId = 0;
          if( $value->locality_id != 0 ){
            $cityId = $localityCityMap[ $value->locality_id ];
            $accessRole = $accessData['city'][ $cityId ][0];
          } else if( $value->city_id != 0 ){
            $accessRole = $accessData['city'][ $value->city_id ][0];
          } else if( $value->state_id != 0 ){
            $accessRole = $accessData['state'][ $value->state_id ][0];
          } else if( $value->country_id != 0 ){
            $accessRole = $accessData['country'][ $value->country_id ][0];
          }
          $permission = array( 'enable' => 0, 'authority' => 0 );
          if( !empty( $accessRole ) && $accessRole['id'] != 0 && in_array( $accessRole['id'], $accessRoleIds ) ){
            $permission['enable'] = ( $accessRole['access_level'] >= 1 ) ? 1 : 0;
            $permission['authority'] = ( $accessRole['access_level'] == 2 ) ? 1 : 0;
          }
          if( !empty( $fileResponse['data']  ) ){
            $fileJSON = json_decode( $value->filejson );
            $value['files'] = array();
            foreach( $fileJSON as $key => $id ){
              if( isset( $fileResponse['data'][ $id ] ) ){
                $value['files'][] = $fileResponse['data'][ $id ];
              }
            }
          }
          $value['props'] = array(); $value['polls'] = array();
          if( isset( $postProperties[ $value['id'] ] ) ){
            $value['props'] = $postProperties[ $value['id'] ];
          }
          if( isset( $postPolls[ $value['id'] ] ) ){
            $value['polls'] = $postPolls[ $value['id'] ];
          }
          $value['permissions'] = $permission;
          unset( $value['filejson'] );
          $value['user'] = $userInfos[ $value['user_id'] ];
          unset( $value['user_id'] );
          $data[ $value->post_type ][] = $value;
        }
        $response['data'] = $data;
      } else {
        $response = array( 'error' => 0, 'message' => 'Your Feed is Empty', 'data' => array() );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
