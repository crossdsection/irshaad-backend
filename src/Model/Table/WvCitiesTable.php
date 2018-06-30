<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
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
        if( !empty( $city ) ){
          $stateIds = array();
          foreach ( $city as $key => $value ) {
            if ( !empty( $data ) && strpos( $value['name'], $data['city'] ) !== false ) {
              $cityData[] = array( 'city_id' => $value['id'], 'city_name' => $value['name'], 'state_id' => $value->state_id );
              $stateIds[] = $value->state_id;
            } else if( empty( $data ) ){
              $cityData[] = array( 'city_id' => $value['id'], 'city_name' => $value['name'], 'state_id' => $value->state_id );
              $stateIds[] = $value->state_id;
            }
          }
          $statesRes = $this->WvStates->findStateById( $stateIds, $data );
          $response['data'] = $statesRes['data'];
          $response['data']['cities'] = $cityData;
        }
      }
      return $response;
    }
}
