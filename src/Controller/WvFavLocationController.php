<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvFavLocation Controller
 *
 * @property \App\Model\Table\WvFavLocationTable $WvFavLocation
 *
 * @method \App\Model\Entity\WvFavLocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvFavLocationController extends AppController
{

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
          $postData['userId'] = $_POST['userId'];
        } else {
          $postData = $this->request->getData();
        }
        $localityCheck = false;
        $localityCheckArray = array( 'locality', 'city', 'latitude', 'longitude', 'state', 'country' );
        $localityData = array();
        foreach ( $localityCheckArray as $key => $value ) {
          if( isset( $postData[ $value ] ) && ( $postData[ $value ] != '' or $postData[ $value ] != 0 ) ){
            $localityData[ $value ] = $postData[ $value ];
            $localityCheck = true;
          } else {
            $localityCheck = false;
            break;
          }
        }
        if( $localityCheck ){
          $localeRes = $this->WvFavLocation->WvCities->WvLocalities->findLocality( $localityData );
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
            $saveData['user_id'] = $postData['userId'];
            if( isset( $postData[ 'latitude' ] ) )
              $saveData[ 'latitude' ] = $postData[ 'latitude' ];
            if( isset( $postData[ 'longitude' ] ) )
              $saveData[ 'longitude' ] = $postData[ 'longitude' ];
            if( isset( $postData[ 'level' ] ) )
              $saveData[ 'level' ] = $postData[ 'level' ];
          }
          $return = $this->WvFavLocation->add( $saveData );
          if( $return ){
            $search = $this->WvFavLocation->buildDataForSearch( array( $return ) );
            $result = $this->WvFavLocation->retrieveAddresses( $search );
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
     * @param string|null $id Wv Fav Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
     public function get()
     {
       $response = array( 'error' => 0, 'message' => '', 'data' => array() );
       $wvFavLocations = $this->WvFavLocation->find('all', ['limit' => 200])->where(['user_id' => $_GET['userId']])->toArray();
       if( !empty( $wvFavLocations ) ){
         $search = $this->WvFavLocation->buildDataForSearch( $wvFavLocations );
         $ret = $this->WvFavLocation->retrieveAddresses( $search );
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
         $postData['userId'] = $_POST['userId'];
       } else {
         $postData = $this->request->getData();
       }
       if( isset( $postData['favLocationId'] ) ){
         if( $this->WvFavLocation->remove( array( $postData['favLocationId'] ) ) ){
           $response = array( 'error' => 0, 'message' => '', 'data' => array() );
         }
       }
       $this->response = $this->response->withType('application/json')
                                        ->withStringBody( json_encode( $response ) );
       return $this->response;
     }
}
