<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WvFileuploads Controller
 *
 * @property \App\Model\Table\WvFileuploadsTable $WvFileuploads
 *
 * @method \App\Model\Entity\WvFileupload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WvFileuploadsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $wvFileuploads = $this->paginate($this->WvFileuploads);

        $this->set(compact('wvFileuploads'));
    }

    /**
     * View method
     *
     * @param string|null $id Wv Fileupload id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wvFileupload = $this->WvFileuploads->get($id, [
            'contain' => []
        ]);

        $this->set('wvFileupload', $wvFileupload);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $response = array( 'error' => 0, 'message' => '', 'data' => array() );
        if ($this->request->is('post')) {
          $fileData = array();
          if( isset( $this->request->data['file'] ) && !empty( $this->request->data['file'] ) ){
            $file = $this->request->data['file'];
            $filePath = 'img' . DS . 'upload' . DS . $file['name'];
            $fileUrl = WWW_ROOT . DS . $filePath;
            $localFileUrl = 'webroot' . DS . $filePath;
            $fileArr = array(
              'fileurl' => $filePath,
              'filetype' => $file['type'],
              'size' => $file['size']
            );
            if( move_uploaded_file( $file['tmp_name'], $fileUrl ) ){
              $fileData[] = array( 'filepath' => $localFileUrl, 'filetype' => $file['type'] );
            }
          }
          $lastInsertId = $this->WvFileuploads->saveFiles($fileData);
          if ( $lastInsertId != 0 ) {
            $response = array( 'error' => 0, 'message' => 'Post Submitted', 'data' => array( $lastInsertId ) );
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
     * @param string|null $id Wv Fileupload id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wvFileupload = $this->WvFileuploads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wvFileupload = $this->WvFileuploads->patchEntity($wvFileupload, $this->request->getData());
            if ($this->WvFileuploads->save($wvFileupload)) {
                $this->Flash->success(__('The wv fileupload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wv fileupload could not be saved. Please, try again.'));
        }
        $this->set(compact('wvFileupload'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wv Fileupload id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wvFileupload = $this->WvFileuploads->get($id);
        if ($this->WvFileuploads->delete($wvFileupload)) {
            $this->Flash->success(__('The wv fileupload has been deleted.'));
        } else {
            $this->Flash->error(__('The wv fileupload could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
