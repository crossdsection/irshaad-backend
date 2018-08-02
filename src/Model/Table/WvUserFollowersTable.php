<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * WvUserFollowers Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FollowusersTable|\Cake\ORM\Association\BelongsTo $Followusers
 *
 * @method \App\Model\Entity\WvUserFollower get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvUserFollower newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvUserFollower[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvUserFollower|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvUserFollower|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvUserFollower patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvUserFollower[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvUserFollower findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvUserFollowersTable extends Table
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

        $this->setTable('wv_user_followers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'followuser_id' ) ]);

        $this->belongsTo('WvUser', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WvUser', [
            'foreignKey' => 'followuser_id',
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
        // $rules->add($rules->existsIn(['user_id'], 'Users'));
        // $rules->add($rules->existsIn(['followuser_id'], 'Followusers'));

        return $rules;
    }

    /**
     * data['user_id']
     * data['followuser_id']
     */
    public function follow( $data ){
      $return = false;
      if( !empty( $data ) && isset( $data['user_id'] ) && isset( $data['followuser_id'] ) ){
        $userFollowers = TableRegistry::get('WvUserFollowers');
        $entity = $userFollowers->newEntity();
        $entity = $userFollowers->patchEntity( $entity, $data );
        $entity = $this->fixEncodings( $entity );
        $record = $userFollowers->save( $entity );
        if( isset( $record->id ) ){
          $return = $record->id;
        }
      }
      return $return;
    }

    /**
     * data['user_id']
     * data['followuser_id']
     */
    public function unfollow( $data ){
      $return = false;
      if( !empty( $data ) && isset( $data['user_id'] ) && isset( $data['followuser_id'] ) ){
        $userFollowers = TableRegistry::get('WvUserFollowers');
        $entity = $userFollowers->find()->where([ 'user_id' => $data['user_id'], 'followuser_id' => $data['followuser_id'] ] )->toArray();
        $entityIds = Hash::extract( $entity, '{n}.id');
        $entityIds = $this->decodeHashid( $entityIds );
        if( !empty( $entityIds ) ){
          $ret = $this->deleteAll([ 'id IN' => $entityIds ]);
        }
      }
      return $return;
    }

    /**
     * data['user_id']
     */
    public function getfollowers( $data ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array()  );
      if( !empty( $data ) && isset( $data['user_id'] ) ){
        $userFollowers = TableRegistry::get('WvUserFollowers');
        $entity = $userFollowers->find()->where([ 'followuser_id' => $data['user_id'] ] )->toArray();
        $followerIds = Hash::extract( $entity, '{n}.user_id' );
        $userData = $this->WvUser->getUserList( $entityIds );
        $response['data'] = $userData;
      }
      return $response;
    }

    /**
     * data['user_id']
     */
    public function getfollowing( $data ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array()  );
      if( !empty( $data ) && isset( $data['user_id'] ) ){
        $userFollowers = TableRegistry::get('WvUserFollowers');
        $entity = $userFollowers->find()->where([ 'user_id' => $data['user_id'] ] )->toArray();
        $followerIds = Hash::extract( $entity, '{n}.followuser_id' );
        $userData = $this->WvUser->getUserList( $entityIds );
        $response['data'] = $userData;
      }
      return $response;
    }

    /**
     *
     */
    public function getfollowerCount( $userId = null ){
      $response = null;
      if( $userId != null ){
        $userFollowers = TableRegistry::get('WvUserFollowers');
        $totalFollowers = $userFollowers->find()->where([ 'followuser_id' => $userId ] )->count();
        $response = $totalFollowers;
      }
      return $response;
    }

    /**
     * data['user_id']
     */
    public function getfollowingCount( $userId = null ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array()  );
      if( $userId != null ){
        $userFollowers = TableRegistry::get('WvUserFollowers');
        $totalFollowing = $userFollowers->find()->where([ 'user_id' => $userId ] )->count();
        $response = $totalFollowing;
      }
      return $response;
    }
}
