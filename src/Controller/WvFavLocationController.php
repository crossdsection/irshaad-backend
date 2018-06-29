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
