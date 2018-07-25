<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvCountries Controller
 *
 * @property \App\Model\Table\WvCountriesTable $WvCountries
 *
 * @method \App\Model\Entity\WvCountry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvCountriesController extends AppController {

  public function get(){
    $response = array( 'error' => 0, 'message' => '', 'data' => array() );
    $response['data'] = $this->WvCountries->find('all',[
      'fields' => ['country_code','name','phonecode']
    ]);
    $this->response = $this->response->withType('application/json')
                                     ->withStringBody( json_encode( $response ) );
    return $this->response;
  }
}
