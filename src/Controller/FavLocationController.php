<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FavLocation Controller
 *
 * @property \App\Model\Table\FavLocationTable $FavLocation
 *
 * @method \App\Model\Entity\FavLocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FavLocationController extends AppController
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
        $favLocationCheck = array();
        if( isset( $postData['longitude'] ) && isset( $postData['latitude'] ) ){
          $favLocationCheck = array( 'latitude' => $postData['latitude'], 'longitude' => $postData['longitude'], 'user_id' => $postData['user_id'], 'level' => $postData['level'] );
        }
        if( $this->FavLocation->exist( $favLocationCheck ) ){
          $response = array( 'error' => 1, 'message' => 'Favourite Location Exists.', 'data' => array( 'exist' => true ) );
        } else if( isset( $postData['longitude'] ) && isset( $postData['latitude'] ) ){
          if( isset( $postData['countryShortName'] ) ){
            $postData['country_code'] = $postData['countryShortName'];
            unset( $postData['countryShortName'] );
          }
          $localeRes = array( 'error' => 1 );
          if( !empty( $postData['locality'] ) ){
            $localeRes = $this->FavLocation->Cities->Localities->findLocality( $postData );
          } else if( !empty( $postData['city'] ) ){
            $localeRes = $this->FavLocation->Cities->findCities( $postData );
          } else if( !empty( $postData['state'] ) ){
            $localeRes = $this->FavLocation->States->findStates( $postData );
          } else if( !empty( $postData['country'] ) || !empty( $postData['country_code'] ) ){
            $localeRes = $this->FavLocation->Countries->findCountry( $postData );
          }
          $saveData = array();
          if( $localeRes['error'] == 0 ){
            foreach ( $localeRes['data'] as $key => $locale ) {
              if( isset( $locale[0] ) && isset( $locale[0]['locality_id'] ) )
               $saveData['locality_id'] = $locale[0]['locality_id'];
              if( isset( $locale[0] ) && isset( $locale[0]['city_id'] ) )
               $saveData['city_id'] = $locale[0]['city_id'];
              if( isset( $locale[0] ) && isset( $locale[0]['state_id'] ) )
               $saveData['state_id'] = $locale[0]['state_id'];
              if( isset( $locale[0] ) && isset( $locale[0]['country_id'] ) )
               $saveData['country_id'] = $locale[0]['country_id'];
            }
            $saveData['user_id'] = $postData['user_id'];
            if( isset( $postData[ 'latitude' ] ) )
              $saveData[ 'latitude' ] = $postData[ 'latitude' ];
            if( isset( $postData[ 'longitude' ] ) )
              $saveData[ 'longitude' ] = $postData[ 'longitude' ];
            if( isset( $postData[ 'level' ] ) )
              $saveData[ 'level' ] = $postData[ 'level' ];
          }
          $return = $this->FavLocation->add( $saveData );
          if( $return ){
            $search = $this->FavLocation->buildDataForSearch( array( $return ) );
            $result = $this->FavLocation->retrieveAddresses( $search );
            $response = array( 'error' => 0, 'message' => 'Favourite Location Saved', 'data' => $result['data'] );
          } else {
            $response = array( 'error' => -1, 'message' => 'Please Try Again', 'data' => array() );
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
     * @param string|null $id  Fav Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
     public function get()
     {
       $response = array( 'error' => 0, 'message' => '', 'data' => array() );
       $userData = $this->FavLocation->User->getUserList( array( $_GET['userId'] ), array( 'id', 'default_location_id' ) );
       $conditions = array( 'user_id' => $_GET['userId'] );
       $isHome = $this->request->query('isHome');
       if( $isHome ){
         $conditions[] = array( 'id' => $userData[ $_GET['userId'] ]['default_location_id'] );
       }
       $wvFavLocations = $this->FavLocation->find('all', ['limit' => 200])->where( $conditions )->toArray();
       if( !empty( $wvFavLocations ) ){
         $search = $this->FavLocation->buildDataForSearch( $wvFavLocations, $userData[ $_GET['userId'] ] );
         $ret = $this->FavLocation->retrieveAddresses( $search );
         $response['data'] = $ret['data'];
       } else {
         $response = array( 'error' => 0, 'message' => 'No Favourite Locations', 'data' => array() );
       }
       $this->response = $this->response->withType('application/json')
                                        ->withStringBody( json_encode( $response ) );
       return $this->response;
     }

     public function delete(){
       $response = array( 'error' => 1, 'message' => 'Request Failed', 'data' => array() );
       $postData = $this->request->input('json_decode', true);
       if( !empty( $postData ) ){
         $postData['user_id'] = $_POST['userId'];
       } else {
         $postData = $this->request->getData();
       }
       if( isset( $postData['latitude'] ) && isset( $postData['longitude'] ) && isset( $postData['level'] ) && $postData['latitude'] != 0 && $postData['longitude'] != 0 ){
         if( $this->FavLocation->remove( array( $postData ) ) ){
           $response = array( 'error' => 0, 'message' => 'Location Deleted Successfully.', 'data' => array() );
         }
       }
       $this->response = $this->response->withType('application/json')
                                        ->withStringBody( json_encode( $response ) );
       return $this->response;
     }

     public function checkExist(){
       $response = array( 'error' => 1, 'message' => 'Request Failed', 'data' => array() );
       $getData = $this->request->getQuery();
       if( !empty( $getData ) ){
         $getData['user_id'] = $_GET['userId'];
       }
       if( isset( $getData['latitude'] ) && isset( $getData['longitude'] ) && $getData['latitude'] != 0 && $getData['longitude'] != 0 ){
         if( $this->FavLocation->exist( $getData ) ){
           $response = array( 'error' => 0, 'message' => 'Exists', 'data' => array('exist' => true, 'notExist' => false) );
         } else {
           $response = array( 'error' => 0, 'message' => 'Does Not Exists', 'data' => array( 'exist' => false, 'notExist' => true) );
         }
       }
       $this->response = $this->response->withType('application/json')
                                        ->withStringBody( json_encode( $response ) );
       return $this->response;
     }

     public function setDefault(){
       $response = array( 'error' => 1, 'message' => 'Request Failed', 'data' => array() );
       $postData = $this->request->input('json_decode', true);
       if( !empty( $postData ) ){
         $postData['user_id'] = $_POST['userId'];
       } else {
         $postData = $this->request->getData();
       }
       $continue = false;
       if( isset( $postData['latitude'] )
            && isset( $postData['longitude'] )
              && $postData['latitude'] != 0
                && $postData['longitude'] != 0 ){
         $continue = true;
       }
       if( isset( $postData['favlocationId'] ) ){
         $postData['id'] = $postData['favlocationId'];
         unset( $postData['favlocationId'] );
         $continue = true;
       }
       if( $continue ){
         $record = $this->FavLocation->find()->where( $postData )->toArray();
         if( !empty( $record ) && $record[0]->id ){
           $search = $this->FavLocation->buildDataForSearch( $record );
           $result = $this->FavLocation->retrieveAddresses( $search );
           $user = array( 'id' => $postData['user_id'], 'default_location_id' => $record[0]->id, 'address' => $result['data'][0]['address_string'], 'latitude' => $result['data'][0]['latitude'], 'longitude' => $result['data'][0]['longitude'] );
           $usersUpdated = $this->FavLocation->User->updateUser( array( $user ) );
           if ( !empty( $usersUpdated ) ) {
             $response = array( 'error' => 0, 'message' => 'Default Location Set', 'data' => array() );
           }
         }
       }
       $this->response = $this->response->withType('application/json')
                                        ->withStringBody( json_encode( $response ) );
       return $this->response;
     }
}
