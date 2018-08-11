<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvAreaRatings Controller
 *
 * @property \App\Model\Table\WvAreaRatingsTable $WvAreaRatings
 *
 * @method \App\Model\Entity\WvAreaRating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvAreaRatingsController extends AppController {

  public function rateArea() {
    $response = array( 'error' => 0, 'message' => '', 'data' => array() );
    $jsonData = $this->request->input('json_decode', true);
    if( !empty( $jsonData ) ){
      $jsonData['userId'] = $_POST['userId'];
    } else {
      $jsonData = $this->request->getData();
    }
    if( !empty( $jsonData ) ){
      $saveData = array();
      $saveData['user_id'] = $jsonData['userId'];
      if( isset( $jsonData['areaLevel'] ) ){
        $saveData['area_level'] = $jsonData['areaLevel'];
      }
      if( isset( $jsonData['areaLevelId'] ) ){
        $saveData['area_level_id'] = $jsonData['areaLevelId'];
      }
      if( isset( $jsonData['rating'] ) ){
        $saveData['good'] = ( $jsonData['rating'] == 'good' ) ? 1 : 0;
        $saveData['bad'] = ( $jsonData['rating'] == 'bad' ) ? 1 : 0;
      }
      if( !empty( $saveData ) ){
         $result = $this->WvAreaRatings->saveratings( $saveData );
         if( $result ){
           $response['data'] = $result;
         } else {
           $response = array( 'error' => 1, 'message' => 'Failed!', 'data' => array() );
         }
      }
    }
    $this->response = $this->response->withType('application/json')
                                     ->withStringBody( json_encode( $response ) );
    return $this->response;
  }
}
