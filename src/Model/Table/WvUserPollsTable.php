<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * WvUserPolls Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PollsTable|\Cake\ORM\Association\BelongsTo $Polls
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\WvUserPoll get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvUserPoll newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvUserPoll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvUserPoll|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvUserPoll|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvUserPoll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvUserPoll[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvUserPoll findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvUserPollsTable extends Table
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

        $this->setTable('wv_user_polls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'poll_id', 'post_id' ) ]);

        $this->belongsTo('WvUser', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvPolls', [
            'foreignKey' => 'poll_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvPost', [
            'foreignKey' => 'post_id',
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
        $rules->add($rules->existsIn(['user_id'], 'WvUser'));
        $rules->add($rules->existsIn(['poll_id'], 'WvPolls'));
        $rules->add($rules->existsIn(['post_id'], 'WvPost'));

        return $rules;
    }

    public function saveUserPolls( $postData ){
      $return = false;
      if( !empty( $postData ) ){
        $userPoll = TableRegistry::get('WvUserPolls');
        $dataCheck = $this->find('all')->where([ 'user_id' => $postData['user_id'], 'post_id' => $postData['post_id'] ])->toArray();
        $polls = $this->WvPolls->getPolls( $postData['post_id'] );
        $pollIds = Hash::extract( $polls[ $postData[ 'post_id' ] ], '{n}.id' );
        if( empty( $dataCheck ) && !empty( $polls ) && in_array( $postData['poll_id'], $pollIds ) ){
          $entity = $userPoll->newEntity();
          $entity = $userPoll->patchEntity( $entity, $postData );
          $record = $userPoll->save( $entity );
          $incrementCounter = $this->WvPolls->newVote( $postData );
          if( isset( $record->id ) && $incrementCounter ){
            $return = $record->id;
          }
        }
      }
      return $return;
    }
}
