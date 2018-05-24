<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WvMinistry Model
 *
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\WvMinistry get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvMinistry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvMinistry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvMinistry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvMinistry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvMinistry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvMinistry findOrCreate($search, callable $callback = null, $options = [])
 */
class WvMinistryTable extends Table
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

        $this->setTable('wv_ministry');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
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
            ->scalar('ministry_name')
            ->maxLength('ministry_name', 256)
            ->requirePresence('ministry_name', 'create')
            ->notEmpty('ministry_name');

        $validator
            ->boolean('ministry_status')
            ->requirePresence('ministry_status', 'create')
            ->notEmpty('ministry_status');

        $validator
            ->scalar('ministry_head_profilepic')
            ->maxLength('ministry_head_profilepic', 100)
            ->requirePresence('ministry_head_profilepic', 'create')
            ->notEmpty('ministry_head_profilepic');

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
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
