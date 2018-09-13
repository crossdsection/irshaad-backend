<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AreaRatings Controller
 *
 * @property \App\Model\Table\AreaRatingsTable $AreaRatings
 *
 * @method \App\Model\Entity\AreaRating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreaRatingsController extends AppController {

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
         $result = $this->AreaRatings->saveratings( $saveData );
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

  public function getdatewiseratings() {
    $response = array( 'error' => 0, 'message' => '', 'data' => array() );
    $getData = $this->request->query();
    if( !empty( $jsonData ) ){
      $getData['userId'] = $_GET['userId'];
    }
    if( !empty( $getData ) ){
      $data = $this->AreaRatings->getDateWiseRatings( $getData );
      if( !empty( $data ) ){
        $response = array( 'error' => 0, 'message' => '', 'data' => $data );
      }
    }
    $this->response = $this->response->withType('application/json')
                                     ->withStringBody( json_encode( $response ) );
    return $this->response;
  }
}
