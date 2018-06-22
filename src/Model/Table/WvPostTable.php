<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * WvPost Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Departments
 * @property |\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Countries
 * @property |\Cake\ORM\Association\BelongsTo $States
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 * @property |\Cake\ORM\Association\BelongsTo $Localities
 *
 * @method \App\Model\Entity\WvPost get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvPost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvPost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvPost|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvPost|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvPost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvPost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvPost findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvPostTable extends Table
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

        $this->setTable('wv_post');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('WvDepartments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvUser', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvCountries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvStates', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvCities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvLocalities', [
            'foreignKey' => 'locality_id',
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
            ->integer('total_likes')
            // ->requirePresence('total_likes', 'create')
            ->notEmpty('total_likes');

        $validator
            ->integer('total_comments')
            // ->requirePresence('total_comments', 'create')
            ->notEmpty('total_comments');

        $validator
            ->scalar('title')
            // ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('details')
            ->maxLength('details', 512)
            ->requirePresence('details', 'create')
            ->notEmpty('details');

        $validator
            ->scalar('filejson')
            ->maxLength('filejson', 512)
            ->requirePresence('filejson', 'create')
            ->notEmpty('filejson');

        $validator
            ->boolean('poststatus')
            // ->requirePresence('poststatus', 'create')
            ->notEmpty('poststatus');

        $validator
            ->scalar('location')
            ->maxLength('location', 100)
            // ->requirePresence('location', 'create')
            ->notEmpty('location');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 100)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 100)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

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
        // $rules->add($rules->existsIn(['department_id'], 'WvDepartments'));
        // $rules->add($rules->existsIn(['user_id'], 'WvUser'));
        // $rules->add($rules->existsIn(['country_id'], 'WvCountries'));
        // $rules->add($rules->existsIn(['state_id'], 'WvStates'));
        // $rules->add($rules->existsIn(['city_id'], 'WvCities'));
        // $rules->add($rules->existsIn(['locality_id'], 'WvLocalities'));

        return $rules;
    }

    public function savePost( $postData = array() ){
      $return = false;
      if( !empty( $postData ) ){
        $post = TableRegistry::get('WvPost');
        $entity = $post->newEntity();
        $entity = $post->patchEntity( $entity, $postData );
        $record = $post->save( $entity );
        if( $record->id ){
          $return = true;
        }
      }
      return $return;
    }
}
