<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * WvPost Controller
 *
 * @property \App\Model\Table\WvPostTable $WvPost
 *
 * @method \App\Model\Entity\WvPost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvPostController extends AppController
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
          $postData['userId'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        $saveData = array(); $continue = false;
        $addressString = '';
        if( isset( $postData['level'] ) ){
          switch( $postData['level'] ){
            case 'locality' :
              $localeRes = $this->WvPost->WvLocalities->findLocality( $postData )['data'];
              if( !empty( $localeRes['localities'] ) ){
                $saveData['locality_id'] = $localeRes['localities'][0]['locality_id'];
                $addressString = $localeRes['localities'][0]['locality_name'].', '.$localeRes['cities'][0]['city_name'].', '.$localeRes['states'][0]['state_name'].', '.$localeRes['countries'][0]['country_name'];
                $continue = true;
              }
              break;
            case 'city' :
              $cityRes = $this->WvPost->WvCities->findCities( $postData )['data'];
              if( !empty( $cityRes['cities'] ) ){
                $saveData['city_id'] = $cityRes['cities'][0]['city_id'];
                $addressString = $cityRes['cities'][0]['city_name'].', '.$cityRes['states'][0]['state_name'].', '.$cityRes['countries'][0]['country_name'];
                $continue = true;
              }
              break;
            case 'state' :
              $stateRes = $this->WvPost->WvStates->findStates( $postData )['data'];
              if( !empty( $stateRes['states'] ) ){
                $saveData['state_id'] = $stateRes['states'][0]['state_id'];
                $addressString = $stateRes['states'][0]['state_name'].', '.$stateRes['countries'][0]['country_name'];
                $continue = true;
              }
              break;
            case 'country' :
              $countryRes = $this->WvPost->WvCountries->findCountry( $postData )['data'];
              if( !empty( $countryRes['countries'] ) ){
                $saveData['country_id'] = $countryRes['countries'][0]['country_id'];
                $addressString = $countryRes['countries'][0]['country_name'];
                $continue = true;
              }
              break;
            case 'department' :
              if( isset( $postData['department_id'] ) && $postData['department_id'] != null ){
                $saveData['department_id'] = $postData['department_id'];
                $continue = true;
              }
              break;
          }
        }
        $saveData['location'] = $addressString;
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
        $saveData[ 'filejson' ] = json_encode( array() );
        if( !empty( $postData[ 'filejson' ] ) ){
          $saveData[ 'filejson' ] = json_encode( $postData[ 'filejson' ] );
        }
        if( $postData[ 'anonymous' ] ){
          $saveData[ 'anonymous' ] = $postData[ 'anonymous' ];
        }
        if( $postData[ 'draft' ] ){
          $saveData[ 'poststatus' ] = false;
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
      if( !empty( $wvPost ) ){
        $response['data'] = $this->WvPost->retrievePostDetailed( $wvPost );
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
      $getData = $this->request->query();
      $postData = $this->request->getData();
      $requestData = array_merge( $getData, $postData );
      if( !isset( $requestData['userId'] ) && isset( $_POST['userId'] ) ){
        $requestData['userId'] = $_POST['userId'];
        $requestData['accessRoleIds'] = $_POST['accessRoleIds'];
      }
      if( !isset( $requestData['mcph'] ) && isset( $_POST['userId'] ) ){
        $requestData['mcph'] = $requestData['userId'];
      }
      if( isset( $requestData['page'] ) ){
        $conditions = array();
        $orderBy = array();
        if( isset( $requestData['posttype'] ) ){
          $conditions[] = array( 'post_type' => $requestData['posttype'] );
        }
        if( isset( $requestData['mcph'] ) ){
          $conditions[] = array( 'user_id' => $requestData['mcph'] );
        }
        if( isset( $requestData['draft'] ) && $requestData['draft'] == 1 && $requestData['mcph'] != $requestData['userId'] ){
          $conditions[] = array( 'poststatus' => 0 );
        } else {
          $conditions[] = array( 'poststatus' => 1 );
        }
        if( isset( $requestData['most_upvoted'] ) && $requestData['most_upvoted'] == 1 ){
          $orderBy[] = 'total_upvotes DESC';
        }
        if( isset( $requestData['sort_datetime'] ) && $requestData['sort_datetime'] == 1 ){
          $orderBy[] = 'created ASC';
        } else {
          $orderBy[] = 'created DESC';
        }
        $query = $this->WvPost->find('all');
        $wvPost = $query->page( $requestData['page'] );
        if( !empty( $conditions ) ){
          $wvPost = $query->where( $conditions );
        }
        if( isset( $requestData['count'] ) ){
          $wvPost = $query->limit( $requestData['count'] );
        } else {
          $wvPost = $query->limit( 10 );
        }
        $wvPost = $query->order( $orderBy );
        if( !empty( $wvPost ) ){
          $response['data'] = $this->WvPost->retrievePostDetailed( $wvPost );
        } else {
          $response = array( 'error' => 0, 'message' => 'Your Feed is Empty.', 'data' => array() );
        }
      } else {
        $response = array( 'error' => 1, 'message' => 'Invalid Request.', 'data' => array() );
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }
}
