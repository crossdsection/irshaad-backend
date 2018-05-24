<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
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
}
