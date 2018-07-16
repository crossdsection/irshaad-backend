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
            $file = $this->request->getData('file');
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
}
