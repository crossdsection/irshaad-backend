<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * WvLocalities Model
 *
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\WvLocality get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvLocality newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvLocality[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvLocality|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvLocality|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvLocality patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvLocality[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvLocality findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvLocalitiesTable extends Table
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

        $this->setTable('wv_localities');

        $this->addBehavior('Timestamp');

        $this->belongsTo('WvCities', [
            'foreignKey' => 'city_id',
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
        $rules->add($rules->existsIn(['city_id'], 'WvCities'));

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
        $cityRes = $this->WvCities->findCities( $data );
        if( empty( $localities ) && !empty( $cityRes['data'] ) ){
          unset( $data['city'] );
          $data['city_id'] = $cityRes['data']['cities'][0]['city_id'];
          $returnId = $this->addLocality( $data );
          if ( $returnId != 0 ){
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
     * data['locality']
     * data['city_id']
     * data['latitude']
     * data['longitude']
     */
    public function addLocality( $data ){
      $return = 0;
      if( !empty( $data ) ){
        $locality = TableRegistry::get('WvLocalities');
        $entity = $locality->newEntity();
        $entity = $locality->patchEntity( $entity, $data );
        $record = $locality->save( $entity );
        if( $record->id ){
          $return = $record->id;
        }
      }
      return $return;
    }
}
