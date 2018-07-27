<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WvCountries Model
 *
 * @method \App\Model\Entity\WvCountry get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvCountry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvCountry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvCountry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvCountry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvCountry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvCountry findOrCreate($search, callable $callback = null, $options = [])
 */
class WvCountriesTable extends Table
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

        $this->setTable('wv_countries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->scalar('country_code')
            ->maxLength('country_code', 3)
            ->requirePresence('country_code', 'create')
            ->notEmpty('country_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('phonecode')
            ->requirePresence('phonecode', 'create')
            ->notEmpty('phonecode');

        return $validator;
    }

    public function findCountryById( $countryIds, $data = array() ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $countryIds ) ){
        $countryData = array();
        $countries = $this->find('all')->where([ 'id IN' => $countryIds ])->toArray();
        foreach ( $countries as $key => $value ) {
          $countryData[] = array( 'country_id' => $value['id'], 'country_name' => $value['name'], 'country_code' => $value['country_code'] );
        }
        $response['data'] = array( 'countries' => $countryData );
      }
      return $response;
    }

    /*
     * data['country']
     * response => ( 'country_id' )
     */
    public function findCountry( $data ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array() );
      if( !empty( $data ) && isset( $data['country_code'] ) ){
        $country = $this->find('all')->where([ 'country_code' => $data['country_code'] ])->toArray();
        if( !empty( $country ) ){
          $countryData = array();
          foreach ( $country as $key => $value ) {
            $countryData[] = array( 'country_id' => $value['id'], 'country_name' => $value['name'], 'country_code' => $value->country_code );
          }
          $response['data']['countries'] = $countryData;
        }
      }
      return $response;
    }
}
