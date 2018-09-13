<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Fileuploads Controller
 *
 * @property \App\Model\Table\FileuploadsTable $Fileuploads
 *
 * @method \App\Model\Entity\Fileupload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FileuploadsController extends AppController
{
    public $components = array('Files');

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
          if( !empty( $this->request->getData('file') ) ){
            $result = $this->Files->saveFile( $this->request->getData('file') );
            if( $result ){
              $fileData[] = $result;
            }
          }
          $lastInsertId = $this->Fileuploads->saveFiles($fileData);
          if ( $lastInsertId != null ) {
            $response = array( 'error' => 0, 'message' => 'File Uploaded', 'data' => array( 'fileId' => $lastInsertId, 'filepath' => $result['filepath'] ) );
          } else {
            $response = array( 'error' => 1, 'message' => 'Error', 'data' => array() );
          }
        }
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody( json_encode( $response ) );
        return $this->response;
    }
}
