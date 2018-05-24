<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WvUser Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Departments
 * @property |\Cake\ORM\Association\BelongsTo $Countries
 * @property |\Cake\ORM\Association\BelongsTo $States
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\WvUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvUser findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvUserTable extends Table
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

        $this->setTable('wv_user');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 256)
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 256)
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 20)
            ->allowEmpty('gender');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 256)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 256)
            ->allowEmpty('phone');

        $validator
            ->scalar('address')
            ->maxLength('address', 256)
            ->allowEmpty('address');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 256)
            ->allowEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 256)
            ->allowEmpty('longitude');

        $validator
            ->scalar('profilepic')
            ->maxLength('profilepic', 256)
            ->allowEmpty('profilepic');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        $validator
            ->boolean('email_verified')
            ->requirePresence('email_verified', 'create')
            ->notEmpty('email_verified');

        $validator
            ->integer('adhar_verified')
            ->requirePresence('adhar_verified', 'create')
            ->notEmpty('adhar_verified');

        $validator
            ->requirePresence('authority_flag', 'create')
            ->notEmpty('authority_flag');

        $validator
            ->scalar('access_role_ids')
            ->maxLength('access_role_ids', 1024)
            ->requirePresence('access_role_ids', 'create')
            ->notEmpty('access_role_ids');

        $validator
            ->scalar('rwa_name')
            ->maxLength('rwa_name', 1024)
            ->allowEmpty('rwa_name');

        $validator
            ->scalar('designation')
            ->maxLength('designation', 512)
            ->requirePresence('designation', 'create')
            ->notEmpty('designation');

        $validator
            ->scalar('certificate')
            ->maxLength('certificate', 512)
            ->requirePresence('certificate', 'create')
            ->notEmpty('certificate');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['department_id'], 'Departments'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }
}
