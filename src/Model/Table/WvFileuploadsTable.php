<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * WvFileuploads Model
 *
 * @method \App\Model\Entity\WvFileupload get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvFileupload newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvFileupload[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvFileupload|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvFileupload|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvFileupload patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvFileupload[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvFileupload findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvFileuploadsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('wv_fileuploads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 256)
            ->requirePresence('filepath', 'create')
            ->notEmpty('filepath');

        $validator
            ->scalar('filetype')
            ->maxLength('filetype', 256)
            ->requirePresence('filetype', 'create')
            ->notEmpty('filetype');

        return $validator;
    }

    public function saveFiles( $fileData = array() ){
      $return = 0;
      if( !empty( $fileData ) ){
        $wvFileUploads = TableRegistry::get('WvFileuploads');
        $wvFile = $wvFileUploads->newEntity();
        $wvFile = $wvFileUploads->patchEntity( $wvFile, $fileData[0] );
        $result = $wvFileUploads->save( $wvFile );
        if ( isset( $result->id ) ) {
          $return = $result->id;
        }
      }
      return $return;
    }

    public function getfileurls( $fileUploadIds = array() ){
      $response = array( 'error' => 0, 'data' => array() );
      if( !empty( $fileUploadIds ) ){
        $data = array();
        $wvFiles = $this->find( 'all', [
          'fields' => [ 'id', 'filepath', 'filetype' ]
        ])->where([ 'id IN' => $fileUploadIds ])->toArray();
        foreach ( $wvFiles as $key => $file ) {
          $data[ $file->id ] = array( 'filepath' => $file->filepath, 'filetype' => $file->filetype );
        }
        $response['data'] = $data;
      }
      return $response;
    }
}
