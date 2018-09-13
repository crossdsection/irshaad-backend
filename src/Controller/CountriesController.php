<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Countries Controller
 *
 * @property \App\Model\Table\CountriesTable $Countries
 *
 * @method \App\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountriesController extends AppController {

  public function get(){
    $response = array( 'error' => 0, 'message' => '', 'data' => array() );
    $response['data'] = $this->Countries->find('all',[
      'fields' => [ 'id', 'country_code', 'name', 'phonecode' ]
    ]);
    $this->response = $this->response->withType('application/json')
                                     ->withStringBody( json_encode( $response ) );
    return $this->response;
  }
}
