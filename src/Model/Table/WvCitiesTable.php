<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * WvCities Model
 *
 * @property \App\Model\Table\WvStatesTable|\Cake\ORM\Association\BelongsTo $WvStates
 *
 * @method \App\Model\Entity\WvCity get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvCity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvCity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvCity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvCity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvCity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvCity findOrCreate($search, callable $callback = null, $options = [])
 */
class WvCitiesTable extends Table
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

        $this->setTable('wv_cities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('HashId', [ 'field' => array( 'state_id' ) ]);

        $this->belongsTo('WvStates', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('WvLocalities');
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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
        $rules->add($rules->existsIn(['state_id'], 'WvStates'));
        // $rules->add($rules->existsIn(['city_id'], 'WvStates'));

        return $rules;
    }

    /*
     * data['city']
     * data['country']
     * response => ( 'city_id', 'state_id', 'country_id' )
     */
    public function findCities( $data ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $data ) && isset( $data['city'] ) ){
        $city = $this->find('all')->where([ 'name LIKE' => '%'.$data['city'].'%' ])->toArray();
        $cityData = array();
        if( !empty( $city ) ){
          $stateIds = array();
          foreach ( $city as $key => $value ) {
            $cityData[] = array( 'city_id' => $value['id'], 'city_name' => $value['name'], 'state_id' => $value->state_id );
            $stateIds[] = $value->state_id;
          }
          $statesRes = $this->WvStates->findStateById( $stateIds, $data );
        } else {
          $statesRes = $this->WvStates->findStates( $data );
          if( !empty( $statesRes['data'] ) ){
            $countries = $statesRes['data']['countries'];
            $states = $statesRes['data']['states'];
            foreach ( $states as $key => $value ) {
              if( strpos( $value['state_name'], $data['state'] ) !== false ){
                $saveCity = array( 'name' => $data['city'], 'state_id' => $value['state_id'] );
                $cityId = $this->addCities( $saveCity );
                $cityData[] = array( 'city_id' => $cityId, 'city_name' => $data['city'], 'state_id' => $value['state_id'] );
              }
            }
          }
        }
        $response['data'] = $statesRes['data'];
        $response['data']['cities'] = $cityData;
      }
      return $response;
    }

    public function findCitiesById( $cityIds, $data = array() ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $cityIds ) ){
        $cities = $this->find('all')->where([ 'id IN' => $cityIds ])->toArray();
        if( !empty( $cities ) ){
          $stateIds = array();
          foreach ( $cities as $key => $value ) {
            $cityData[] = array( 'city_id' => $value['id'], 'city_name' => $value['name'], 'state_id' => $value->state_id );
            $stateIds[] = $value->state_id;
          }
          $statesRes = $this->WvStates->findStateById( $stateIds, $data );
          $response['data'] = $statesRes['data'];
          $response['data']['cities'] = $cityData;
        }
      }
      return $response;
    }

    /*
     * data['name']
     * data['state_id']
     */
    public function addCities( $data ){
      $return = 0;
      if( !empty( $data ) ){
        $city = TableRegistry::get('WvCities');
        $entity = $city->newEntity();
        $entity = $city->patchEntity( $entity, $data );
        $record = $city->save( $entity );
        if( $record->id ){
          $return = $this->encodeId( $record->id );
        }
      }
      return $return;
    }
}
