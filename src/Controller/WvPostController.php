<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvPost Controller
 *
 * @property \App\Model\Table\WvPostTable $WvPost
 *
 * @method \App\Model\Entity\WvPost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvPostController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['WvDepartments', 'WvUsers', 'WvCountries', 'WvStates', 'WvCities', 'WvLocalities']
        ];
        $wvPost = $this->paginate($this->WvPost);

        $this->set(compact('wvPost'));
    }

    /**
     * View method
     *
     * @param string|null $id Wv Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wvPost = $this->WvPost->get($id, [
            'contain' => ['WvDepartments', 'WvUsers', 'WvCountries', 'WvStates', 'WvCities', 'WvLocalities']
        ]);

        $this->set('wvPost', $wvPost);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      $wvPost = $this->WvPost->newEntity();
      if ( $this->request->is('post') ) {
          $wvPost = $this->WvPost->patchEntity($wvPost, $this->request->getData());
          if ($this->WvPost->save($wvPost)) {
              $this->Flash->success(__('The wv post has been saved.'));

              return $this->redirect(['action' => 'index']);
          }
          $this->Flash->error(__('The wv post could not be saved. Please, try again.'));
      }
      $this->response = $this->response->withType('application/json')
                                       ->withStringBody( json_encode( $response ) );
      return $this->response;
    }

    /**
     * Edit method
     *
     * @param string|null $id Wv Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wvPost = $this->WvPost->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wvPost = $this->WvPost->patchEntity($wvPost, $this->request->getData());
            if ($this->WvPost->save($wvPost)) {
                $this->Flash->success(__('The wv post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv post could not be saved. Please, try again.'));
        }
        $wvDepartments = $this->WvPost->WvDepartments->find('list', ['limit' => 200]);
        $wvUsers = $this->WvPost->WvUsers->find('list', ['limit' => 200]);
        $wvCountries = $this->WvPost->WvCountries->find('list', ['limit' => 200]);
        $wvStates = $this->WvPost->WvStates->find('list', ['limit' => 200]);
        $wvCities = $this->WvPost->WvCities->find('list', ['limit' => 200]);
        $wvLocalities = $this->WvPost->WvLocalities->find('list', ['limit' => 200]);
        $this->set(compact('wvPost', 'wvDepartments', 'wvUsers', 'wvCountries', 'wvStates', 'wvCities', 'wvLocalities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wv Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wvPost = $this->WvPost->get($id);
        if ($this->WvPost->delete($wvPost)) {
            $this->Flash->success(__('The wv post has been deleted.'));
        } else {
            $this->Flash->error(__('The wv post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
