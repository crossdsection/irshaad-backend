<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * UserPolls Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PollsTable|\Cake\ORM\Association\BelongsTo $Polls
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\UserPoll get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserPoll newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserPoll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserPoll|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserPoll|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserPoll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserPoll[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserPoll findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserPollsTable extends Table
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

        $this->setTable('user_polls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'poll_id', 'post_id' ) ]);

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Polls', [
            'foreignKey' => 'poll_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Post', [
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
        $rules->add($rules->existsIn(['user_id'], 'User'));
        $rules->add($rules->existsIn(['poll_id'], 'Polls'));
        $rules->add($rules->existsIn(['post_id'], 'Post'));

        return $rules;
    }

    public function saveUserPolls( $postData ){
      $return = false;
      if( !empty( $postData ) ){
        $userPoll = TableRegistry::get('UserPolls');
        $dataCheck = $this->find('all')->where([ 'user_id' => $postData['user_id'], 'post_id' => $postData['post_id'] ])->toArray();
        $polls = $this->Polls->getPolls( array( $postData['post_id'] ) );
        $pollIds = Hash::extract( $polls[ $postData[ 'post_id' ] ]['polls'], '{n}.id' );
        if( empty( $dataCheck ) && !empty( $polls ) && in_array( $postData['poll_id'], $pollIds ) ){
          $entity = $userPoll->newEntity();
          $entity = $userPoll->patchEntity( $entity, $postData );
          $record = $userPoll->save( $entity );
          $incrementCounter = $this->Polls->newVote( $postData );
          if( isset( $record->id ) && $incrementCounter ){
            $return = $record->id;
          }
        }
      }
      return $return;
    }

    public function getUserlistPolled( $postIds = array() ){
      $response = array();
      if( !empty( $postIds ) ){
        $pollData = $this->find('all')->select([ 'user_id', 'post_id' ])->where([ 'post_id IN' => $postIds ])->toArray();
        foreach( $pollData as $poll ){
          if( !isset( $response[ $poll->post_id ] ) ){
            $response[ $poll->post_id ] = array();
          }
          $response[ $poll->post_id ][] = $poll->user_id;
        }
      }
      return $response;
    }
}
