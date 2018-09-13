<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * UserFollowers Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FollowusersTable|\Cake\ORM\Association\BelongsTo $Followusers
 *
 * @method \App\Model\Entity\UserFollower get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserFollower newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserFollower[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserFollower|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserFollower|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserFollower patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserFollower[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserFollower findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserFollowersTable extends Table
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

        $this->setTable('user_followers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'followuser_id' ) ]);

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
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
        $userFollowers = TableRegistry::get('UserFollowers');
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
        $userFollowers = TableRegistry::get('UserFollowers');
        $entity = $userFollowers->find()->where([ 'user_id' => $data['user_id'], 'followuser_id' => $data['followuser_id'] ] )->toArray();
        $entityIds = Hash::extract( $entity, '{n}.id');
        $entityIds = $this->decodeHashid( $entityIds );
        if( !empty( $entityIds ) ){
          $return = $this->deleteAll([ 'id IN' => $entityIds ]);
        }
      }
      return $return;
    }

    /**
    * userId
     */
    public function getfollowers( $userId = null, $searchText = null, $queryConditions = array() ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array()  );
      if( $userId != null ){
        $userFollowers = TableRegistry::get('UserFollowers');
        $query = $userFollowers->find()->where([ 'followuser_id' => $userId ] );
        if( isset( $queryConditions['page'] ) ){
          $query = $query->page( $queryConditions['page'] );
        }
        if( isset( $queryConditions['offset'] ) ){
          $query = $query->limit( $queryConditions['offset'] );
        }
        $entity = $query->toArray();
        $followerIds = Hash::extract( $entity, '{n}.user_id' );
        $userData = $this->User->getUserList( $followerIds, array( 'id', 'profilepic', 'firstname', 'lastname', 'about', 'tagline', 'address', 'profession' ) );
        if( $searchText != null && strlen( $searchText ) > 0 ){
          foreach( $userData as $key => $value ){
            if( !(( stripos( $value['firstname'], $searchText ) !== false ) || ( stripos( $value['lastname'], $searchText ) !== false )) ){
              unset( $userData[ $key ] );
            }
          }
        }
        $response['data'] = array_values( $userData );
      }
      return $response;
    }

    /**
     * data['user_id']
     */
    public function getfollowing( $userId = null, $searchText = null, $queryConditions = array() ){
      $response = array( 'error' => 0, 'message' => '', 'data' => array()  );
      if( $userId != null ){
        $userFollowers = TableRegistry::get('UserFollowers');
        $query = $userFollowers->find()->where([ 'user_id' => $userId ] );
        if( isset( $queryConditions['page'] ) ){
          $query = $query->page( $queryConditions['page'] );
        }
        if( isset( $queryConditions['offset'] ) ){
          $query = $query->limit( $queryConditions['offset'] );
        }
        $entity = $query->toArray();
        $followingIds = Hash::extract( $entity, '{n}.followuser_id' );
        $userData = $this->User->getUserList( $followingIds, array( 'id', 'profilepic', 'firstname', 'lastname', 'about', 'tagline', 'address', 'profession' ) );
        if( $searchText != null && strlen( $searchText ) > 0 ){
          foreach( $userData as $key => $value ){
            if( !(( stripos( $value['firstname'], $searchText ) !== false ) || ( stripos( $value['lastname'], $searchText ) !== false )) ){
              unset( $userData[ $key ] );
            }
          }
        }
        $response['data'] = array_values( $userData );
      }
      return $response;
    }

    /**
     *
     */
    public function getfollowerCount( $userId = null ){
      $response = null;
      if( $userId != null ){
        $userFollowers = TableRegistry::get('UserFollowers');
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
        $userFollowers = TableRegistry::get('UserFollowers');
        $totalFollowing = $userFollowers->find()->where([ 'user_id' => $userId ] )->count();
        $response = $totalFollowing;
      }
      return $response;
    }

    public function compareFollowStatus( $currentUserData = array(), $mcphUserData = array() ){
      $returnData = array();
      if( !empty( $mcphUserData ) ){
        $currentUserIds = Hash::extract( $currentUserData, '{n}.id' );
        $mcphUserIds = Hash::extract( $mcphUserData, '{n}.id' );
        $currentUserDoesNotFollowIds = array_diff( $mcphUserIds, $currentUserIds );
        foreach( $mcphUserData as $mcphUser ){
          if( in_array( $mcphUser['id'], $currentUserDoesNotFollowIds ) ){
            $mcphUser['follows'] = false;
          } else {
            $mcphUser['follows'] = true;
          }
          $returnData[] = $mcphUser;
        }
      }
      return $returnData;
    }
}
