<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * WvStates Model
 *
 * @property \App\Model\Table\WvCountriesTable|\Cake\ORM\Association\BelongsTo $WvCountries
 *
 * @method \App\Model\Entity\WvState get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvState newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvState[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvState|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvState patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvState[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvState findOrCreate($search, callable $callback = null, $options = [])
 */
class WvStatesTable extends Table
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

        $this->setTable('wv_states');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('HashId', [ 'field' => array( 'country_id' ) ]);

        $this->belongsTo('WvCountries', [
            'foreignKey' => 'country_id',
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
        $rules->add($rules->existsIn(['country_id'], 'WvCountries'));

        return $rules;
    }

    public function findStateById( $stateIds, $data = array() ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $stateIds ) ){
        $statesData = array();
        $countryData = array();
        $states = $this->find('all')->where([ 'id IN' => $stateIds ])->toArray();
        $countryIds = array();
        foreach ($states as $key => $value) {
          $statesData[] = array( 'state_id' => $value['id'], 'state_name' => $value['name'], 'country_id' => $value['country_id'] );
          $countryIds[] = $value['country_id'];
        }
        $countryRes = $this->WvCountries->findCountryById( $countryIds, $data );
        $response['data'] = $countryRes['data'];
        $response['data']['states'] = $statesData;
      }
      return $response;
    }

    /*
     * data['state']
     * data['country']
     * response => ( 'state_id', 'country_id' )
     */
    public function findStates( $data ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $data ) && isset( $data['state'] ) ){
        $state = $this->find('all')->where([ 'name LIKE' => '%'.$data['state'].'%' ])->toArray();
        if( !empty( $state ) ){
          $countryIds = array();
          $stateData = array();
          foreach ( $state as $key => $value ) {
            $stateData[] = array( 'state_id' => $value['id'], 'state_name' => $value['name'], 'country_id' => $value->country_id );
            $countryIds[] = $value->country_id;
          }
          $countriesRes = $this->WvCountries->findCountryById( $countryIds, $data );
          $response['data'] = $countriesRes['data'];
          $response['data']['states'] = $stateData;
        } else {
          $countryRes = $this->WvCountries->findCountry( $data );
          if( !empty( $countryRes['data'] ) ){
            $countries = $countryRes['data']['countries'];
            foreach ( $countries as $key => $value ) {
              if( strpos( $value['country_name'], $data['country'] ) !== false ){
                $saveState = array( 'name' => $data['state'], 'country_id' => $value['country_id'] );
                $stateId = $this->addState( $saveState );
                $stateData[] = array( 'state_id' => $stateId, 'state_name' => $data['state'], 'country_id' => $value['country_id'] );
              }
            }
          }
          $response['data'] = $countryRes['data'];
          $response['data']['states'] = $stateData;
        }
      }
      return $response;
    }

    /*
     * data['name']
     * data['state_id']
     */
    public function addState( $data ){
      $return = 0;
      if( !empty( $data ) ){
        $state = TableRegistry::get('WvStates');
        $entity = $state->newEntity();
        $entity = $state->patchEntity( $entity, $data );
        $record = $state->save( $entity );
        if( $record->id ){
          $return = $this->encodeId( $record->id );
        }
      }
      return $return;
    }

}
