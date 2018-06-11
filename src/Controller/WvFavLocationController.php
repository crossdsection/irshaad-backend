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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['WvUsers', 'WvDepartments', 'WvCountries', 'WvStates', 'WvCities', 'WvLocalities']
        ];
        $wvFavLocation = $this->paginate($this->WvFavLocation);

        $this->set(compact('wvFavLocation'));
    }

    /**
     * View method
     *
     * @param string|null $id Wv Fav Location id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wvFavLocation = $this->WvFavLocation->get($id, [
            'contain' => ['WvUsers', 'WvDepartments', 'WvCountries', 'WvStates', 'WvCities', 'WvLocalities']
        ]);

        $this->set('wvFavLocation', $wvFavLocation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if ( $this->request->is('post') ) {
        $saveData = array(); $continue = false;
        $importantKeys = array( 'department_id', 'country_id', 'state_id', 'city_id', 'locality_id' );
        foreach( $importantKeys as $key ){
          if( isset( $this->request->data[ $key ] ) && !empty( $this->request->data[ $key ] ) ){
            $saveData[ $key ] = $this->request->data[ $key ];
            $continue = true;
          } else {
            $saveData[ $key ] = 0;
          }
        }
        if( isset( $this->request->data[ 'title' ] ) && !empty( $this->request->data[ 'title' ] ) ){
          $saveData[ 'title' ] = $this->request->data[ 'title' ];
        } else {
          $continue = false;
        }
        if( isset( $_POST[ 'userId' ] ) && !empty( $_POST[ 'userId' ] ) ){
          $saveData[ 'user_id' ] = $_POST[ 'userId' ];
          $tmp = $this->WvPost->WvUser->WvLoginRecord->getLastLogin( $_POST[ 'userId' ] );
          $saveData[ 'latitude' ] = $tmp[ 'latitude' ];
          $saveData[ 'longitude' ] = $tmp[ 'longitude' ];
        } else {
          $continue = false;
        }
        if( isset( $this->request->data[ 'details' ] ) && !empty( $this->request->data[ 'details' ] ) ){
          $saveData[ 'details' ] = $this->request->data[ 'details' ];
        }
        if( isset( $this->request->data[ 'fileupload' ] ) && !empty( $this->request->data[ 'fileupload' ] ) ){
          $file = $this->request->data[ 'fileupload' ];
          $filePath = 'img' . DS . 'upload' . DS . $file['name'];
          $fileUrl = WWW_ROOT . $filePath;
          $fileArr = array(
            'fileurl' => $filePath,
            'filetype' => $file['type'],
            'size' => $file['size']
          );
          if( move_uploaded_file( $file['tmp_name'], $fileUrl ) ){
            $saveData[ 'filejson' ] = json_encode( $fileArr );
          }
        }
        if ( $this->WvPost->savePost( $saveData ) ) {
          $response = array( 'error' => 0, 'message' => 'Post Submitted', 'data' => array() );
        } else {
          $response = array( 'error' => 1, 'message' => 'Error', 'data' => array() );
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
    public function edit($id = null)
    {
        $wvFavLocation = $this->WvFavLocation->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wvFavLocation = $this->WvFavLocation->patchEntity($wvFavLocation, $this->request->getData());
            if ($this->WvFavLocation->save($wvFavLocation)) {
                $this->Flash->success(__('The wv fav location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv fav location could not be saved. Please, try again.'));
        }
        $wvUsers = $this->WvFavLocation->WvUsers->find('list', ['limit' => 200]);
        $wvDepartments = $this->WvFavLocation->WvDepartments->find('list', ['limit' => 200]);
        $wvCountries = $this->WvFavLocation->WvCountries->find('list', ['limit' => 200]);
        $wvStates = $this->WvFavLocation->WvStates->find('list', ['limit' => 200]);
        $wvCities = $this->WvFavLocation->WvCities->find('list', ['limit' => 200]);
        $wvLocalities = $this->WvFavLocation->WvLocalities->find('list', ['limit' => 200]);
        $this->set(compact('wvFavLocation', 'wvUsers', 'wvDepartments', 'wvCountries', 'wvStates', 'wvCities', 'wvLocalities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wv Fav Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wvFavLocation = $this->WvFavLocation->get($id);
        if ($this->WvFavLocation->delete($wvFavLocation)) {
            $this->Flash->success(__('The wv fav location has been deleted.'));
        } else {
            $this->Flash->error(__('The wv fav location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
