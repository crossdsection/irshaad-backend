<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Localities Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\Locality get($primaryKey, $options = [])
 * @method \App\Model\Entity\Locality newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Locality[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Locality|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Locality|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Locality patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Locality[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Locality findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LocalitiesTable extends Table
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

        $this->setTable('localities');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', [ 'field' => array( 'city_id' ) ]);

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('AreaRatings', [
            'foreignKey' => 'area_level_id',
            'joinType' => 'INNER'
        ]);
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
            // ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->scalar('locality')
            ->maxLength('locality', 100)
            ->requirePresence('locality', 'create')
            ->notEmpty('locality');

        $validator
            ->boolean('active')
            // ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }

    /*
     * data['locality']
     * data['city']
     * data['latitude']
     * data['longitude']
     * data['country']
     * response => ( 'locality_id', 'city_id', 'state_id', 'country_id' )
     */
    public function findLocality( $data ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $data ) && isset( $data['locality'] ) && isset( $data['city'] ) && isset( $data['latitude'] ) && isset( $data['longitude'] ) ){
        $localities = $this->find('all')->where([ 'locality LIKE' => '%'.$data['locality'].'%' ])->toArray();
        $cityRes = $this->Cities->findCities( $data );
        if( empty( $localities ) && !empty( $cityRes['data'] ) ){
          unset( $data['city'] );
          $data['city_id'] = $cityRes['data']['cities'][0]['city_id'];
          $returnId = $this->addLocality( $data );
          if ( $returnId != null ){
            $response['data'] = $cityRes['data'];
            $response['data']['localities'] = array( array( 'locality_id' => $returnId, 'locality_name' => $data['locality'], 'city_id' => $data['city_id'], 'latitude' => $data['latitude'], 'longitude' => $data['longitude'] ) );
          } else {
            $response['error'] = 1;
          }
        } else {
          $response['data'] = $cityRes['data'];
          $response['data']['localities'] = array();
          foreach ($localities as $key => $locality) {
            $response['data']['localities'][] = array(
              'locality_id' => $locality['id'], 'locality_name' => $locality['locality'], 'city_id' => $locality['city_id'],
              'latitude' => $locality['latitude'], 'longitude' => $locality['longitude']
            );
          }
        }
      } else {
        $response['error'] = 1;
      }
      return $response;
    }

    /*
     * locality_id
     * response => ( 'locality', 'city', 'state', 'country' )
     */
    public function findLocalityById( $localityIds ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $localityIds ) && isset( $localityIds ) ){
        $localities = $this->find('all')->where([ 'id IN' => $localityIds ])->toArray();
        $localityData = array();
        if( !empty( $localities ) ){
          $cityIds = array();
          foreach ( $localities as $key => $value ) {
            $localityData[] = array( 'locality_id' => $value['id'], 'locality_name' => $value['locality'], 'city_id' => $value->city_id );
            $cityIds[] = $value->city_id;
          }
          $cityRes = $this->Cities->findCitiesById( $cityIds );
          $response['data'] = $cityRes['data'];
          $response['data']['localities'] = $localityData;
        }
      } else {
        $response['error'] = 1;
      }
      return $response;
    }

    /*
     * data['locality']
     * data['city_id']
     * data['latitude']
     * data['longitude']
     */
    public function addLocality( $data ){
      $return = null;
      if( !empty( $data ) ){
        $locality = TableRegistry::get('Localities');
        $entity = $locality->newEntity();
        $entity = $locality->patchEntity( $entity, $data );
        $record = $locality->save( $entity );
        if( $record->id ){
          $return = $this->encodeId( $record->id );
        }
      }
      return $return;
    }
}
