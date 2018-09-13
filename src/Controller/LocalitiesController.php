<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Localities Controller
 *
 * @property \App\Model\Table\LocalitiesTable $Localities
 *
 * @method \App\Model\Entity\Locality[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocalitiesController extends AppController {

  public function get(){
    $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
    $getData = $this->request->query();
    $userId = null;
    if( isset( $_GET['userId'] ) ){
      $userId = $_GET['userId'];
    }
    if( !empty( $getData ) ){
      $response['error'] = 0; $response['message'] = '';
      if( isset( $getData['level'] ) ){
        switch( $getData['level'] ){
          case 'locality' :
            $localeRes = $this->Localities->findLocality( $getData )['data'];
            $areaLevelId = $localeRes['localities'][0]['locality_id'];
            $areaRating = $this->Localities->AreaRatings->getRatings( $getData['level'], $areaLevelId, $userId );
            $response['data'] = array( 'location' => $localeRes, 'areaRating' => $areaRating );
            break;
          case 'city' :
            $cityRes = $this->Localities->Cities->findCities( $getData )['data'];
            $areaLevelId = $cityRes['cities'][0]['city_id'];
            $areaRating = $this->Localities->AreaRatings->getRatings( $getData['level'], $areaLevelId, $userId );
            $response['data'] = array( 'location' => $cityRes, 'areaRating' => $areaRating );
            break;
          case 'state' :
            $stateRes = $this->Localities->Cities->States->findStates( $getData )['data'];
            $areaLevelId = $stateRes['states'][0]['state_id'];
            $areaRating = $this->Localities->AreaRatings->getRatings( $getData['level'], $areaLevelId, $userId );
            $response['data'] = array( 'location' => $stateRes, 'areaRating' => $areaRating );
            break;
          case 'country' :
            $countryRes = $this->Localities->Cities->States->Countries->findCountry( $getData )['data'];
            $areaLevelId = $countryRes['countries'][0]['country_id'];
            $areaRating = $this->Localities->AreaRatings->getRatings( $getData['level'], $areaLevelId, $userId );
            $response['data'] = array( 'location' => $countryRes, 'areaRating' => $areaRating );
            break;
          case 'world' :
            $areaRating = $this->Localities->AreaRatings->getRatings( $getData['level'], 0, $userId );
            $response['data'] = array( 'location' => array(), 'areaRating' => $areaRating );
            break;
        }
      }
    }
    $this->response = $this->response->withType('application/json')
                                     ->withStringBody( json_encode( $response ) );
    return $this->response;
  }
}
