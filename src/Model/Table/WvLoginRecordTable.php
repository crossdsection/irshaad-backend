<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * WvLoginRecord Model
 *
 * @property \App\Model\Table\WvUserTable|\Cake\ORM\Association\BelongsTo $WvUser
 *
 * @method \App\Model\Entity\WvLoginRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvLoginRecord newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvLoginRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvLoginRecord|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvLoginRecord|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvLoginRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvLoginRecord[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvLoginRecord findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvLoginRecordTable extends Table
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

        $this->setTable('wv_login_record');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('WvUser', [
            'foreignKey' => 'user_id',
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
            ->scalar('latitude')
            ->maxLength('latitude', 256)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 256)
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
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'WvUser'));
        return $rules;
    }

    public function saveLog( $userData = array() ){
      $return = false;
      if( !empty( $userData ) ){
        $loginLog = TableRegistry::get('WvLoginRecord');
        $entity = $loginLog->newEntity();
        $entity = $loginLog->patchEntity( $entity, $userData );
        if( $loginLog->save( $entity ) ){
          $return = true;
        }
      }
      return $return;
    }
}
