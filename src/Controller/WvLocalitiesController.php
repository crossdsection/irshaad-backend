<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvLocalities Controller
 *
 * @property \App\Model\Table\WvLocalitiesTable $WvLocalities
 *
 * @method \App\Model\Entity\WvLocality[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvLocalitiesController extends AppController {

  public function get(){
    $response = array( 'error' => 1, 'message' => 'Invalid Request', 'data' => array() );
    $getData = $this->request->query();
    if( !empty( $getData ) ){
      $response['error'] = 0; $response['message'] = '';
      if( isset( $getData['level'] ) ){
        switch( $getData['level'] ){
          case 'locality' :
            $localeRes = $this->WvLocalities->findLocality( $getData )['data'];
            $response['data'] = $localeRes;
            break;
          case 'city' :
            $cityRes = $this->WvLocalities->WvCities->findCities( $getData )['data'];
            $response['data'] = $cityRes;
            break;
          case 'state' :
            $stateRes = $this->WvLocalities->WvCities->WvStates->findStates( $getData )['data'];
            $response['data'] = $stateRes;
            break;
          case 'country' :
            $countryRes = $this->WvLocalities->WvCities->WvStates->WvCountries->findCountry( $getData )['data'];
            $response['data'] = $countryRes;
            break;
        }
      }
    }
    $this->response = $this->response->withType('application/json')
                                     ->withStringBody( json_encode( $response ) );
    return $this->response;
  }
}
