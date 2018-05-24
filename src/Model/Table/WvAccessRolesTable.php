<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WvAccessRoles Model
 *
 * @property \App\Model\Table\AreaLevelsTable|\Cake\ORM\Association\BelongsTo $AreaLevels
 *
 * @method \App\Model\Entity\WvAccessRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvAccessRole newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvAccessRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvAccessRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvAccessRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvAccessRole[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvAccessRole findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvAccessRolesTable extends Table
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

        $this->setTable('wv_access_roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AreaLevels', [
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 1024)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('area_level')
            ->requirePresence('area_level', 'create')
            ->notEmpty('area_level');

        $validator
            ->integer('access_level')
            ->requirePresence('access_level', 'create')
            ->notEmpty('access_level');

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
        $rules->add($rules->existsIn(['area_level_id'], 'AreaLevels'));

        return $rules;
    }
}
