<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * WvActivitylog Model
 *
 * @property \App\Model\Table\WvUserTable|\Cake\ORM\Association\BelongsTo $WvUser
 * @property \App\Model\Table\WvPostTable|\Cake\ORM\Association\BelongsTo $WvPost
 *
 * @method \App\Model\Entity\WvActivitylog get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvActivitylog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvActivitylog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvActivitylog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvActivitylog|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvActivitylog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvActivitylog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvActivitylog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvActivitylogTable extends Table
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

        $this->setTable('wv_activitylog');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'post_id' ) ]);

        $this->belongsTo('WvUser', [
            'foreignKey' => 'user_id',
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

        $validator
            // ->boolean('upvote')
            // ->requirePresence('upvote', 'create')
            ->notEmpty('upvote');

        $validator
            // ->boolean('downvote')
            // ->requirePresence('downvote', 'create')
            ->notEmpty('downvote');

        $validator
            // ->boolean('bookmark')
            // ->requirePresence('bookmark', 'create')
            ->notEmpty('bookmark');

        $validator
            // ->integer('shares')
            // ->requirePresence('shares', 'create')
            ->notEmpty('shares');

        $validator
            // ->scalar('flag')
            // ->requirePresence('flag', 'create')
            ->notEmpty('flag');

        $validator
            // ->boolean('eyewitness')
            // ->requirePresence('eyewitness', 'create')
            ->notEmpty('eyewitness');

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
        $rules->add($rules->existsIn(['post_id'], 'WvPost'));

        return $rules;
    }

    public function saveActivity( $postData = array() ){
      $return = false;
      if( !empty( $postData ) ){
        $activity = TableRegistry::get('WvActivitylog');
        if( isset( $postData['id'] ) && $postData['id'] != null ){
          $entity = $activity->get( $postData['id'] );
        } else {
          $entity = $activity->newEntity();
        }
        $entity = $activity->patchEntity( $entity, $postData );
        $entity = $this->fixEncodings( $entity );
        $record = $activity->save( $entity );
        if( $record->id ){
          $return = true;
        }
      }
      return $return;
    }

    public function getCumulativeResult( $postIds = array(), $userId = null ){
      $data = array();
      if( !empty( $postIds ) ){
        $tableData = $this->find('all')->where([ 'post_id IN' => $postIds ])->toArray();
        foreach( $tableData as $key => $value ){
          if( !isset( $data[ $value->post_id ] ) ){
            $data[ $value->post_id ] = array( 'upvoteCount' => 0, 'downvoteCount' => 0, 'eyewitnessCount' => 0 );
          }
          if( $value->upvote > 0 )
            $data[ $value->post_id ]['upvoteCount'] = $data[ $value->post_id ]['upvoteCount'] + 1;
          if( $value->downvote > 0 )
            $data[ $value->post_id ]['downvoteCount'] = $data[ $value->post_id ]['downvoteCount'] + 1;
          if( $value->eyewitness > 0 )
            $data[ $value->post_id ]['eyewitnessCount'] = $data[ $value->post_id ]['eyewitnessCount'] + 1;
          if( $userId != null && $userId == $value->user_id ){
            $userStatus = array( 'userVoteStatus' => 0, 'userBookmarkStatus' => 0, 'userFlagStatus' => 0, 'userEyeWitnessStatus' => 0 );
            $userStatus['userVoteStatus'] = ( $value->upvote > 0 ) ? 1 : $userStatus['userVoteStatus'];
            $userStatus['userVoteStatus'] = ( $value->downvote > 0 ) ? -1 : $userStatus['userVoteStatus'];
            $userStatus['userBookmarkStatus'] = ( $value->bookmark > 0 ) ? 1 : $userStatus['userBookmarkStatus'];
            $userStatus['userFlagStatus'] = ( $value->flag > 0 ) ? 1 : $userStatus['userFlagStatus'];
            $userStatus['userEyeWitnessStatus'] = ( $value->eyewitness > 0 ) ? 1 : $userStatus['userEyeWitnessStatus'];
            $data[ $value->post_id ] = array_merge( $data[ $value->post_id ], $userStatus );
          }
        }
        foreach( $postIds as $postId ){
          if( !isset( $data[ $postId ] ) ){
            $data[ $postId ] = array( 'upvoteCount' => 0, 'downvoteCount' => 0, 'eyewitnessCount' => 0, 'userVoteStatus' => 0, 'userBookmarkStatus' => 0, 'userFlagStatus' => 0, 'userEyeWitnessStatus' => 0 );
          }
        }
      }
      return $data;
    }

    public function getProperties( $postId ){
      $data = array();
      if( $postId != 0 && $postId != null ){
        $tableData = $this->find('all')->where([ 'post_id' => $postId ])->toArray();
        $data = array( 'upvotes' => array( 'count' => 0, 'users' => array() ),
                       'downvotes' => array( 'count' => 0, 'users' => array() ),
                       'eyewitness' => array( 'count' => 0, 'users' => array() ) );
        $upvoteUserIds = array(); $downvoteUserIds = array(); $eyewitnessUserIds = array();
        foreach( $tableData as $key => $value ){
          if( $value->upvote > 0 ){
            $data['upvotes']['count'] = $data['upvotes']['count'] + 1;
            $upvoteUserIds[] = $value->user_id;
          }
          if( $value->downvote > 0 ){
            $data['downvotes']['count'] = $data['downvotes']['count'] + 1;
            $downvoteUserIds[] = $value->user_id;
          }
          if( $value->eyewitness > 0 ){
            $data['eyewitness']['count'] = $data['eyewitness']['count'] + 1;
            $eyewitnessUserIds[] = $value->user_id;
          }
        }
        $data['upvotes']['users'] = $this->WvUser->getUserList( $upvoteUserIds );
        $data['downvotes']['users'] = $this->WvUser->getUserList( $downvoteUserIds );
        $data['eyewitness']['users'] = $this->WvUser->getUserList( $eyewitnessUserIds );
      }
      return $data;
    }

    public function compareAndReturn( $postData, $currentState ){
      $data = array();
      if( !empty( $postData ) && !empty( $currentState ) ){
        $upvote = $currentState->upvote;
        if( $postData['upvote'] < 0 || $postData['downvote'] > 0 ){
          $upvote = 0;
        } else if ( $postData['upvote'] > 0 ) {
          $upvote = 1;
        }
        if( $currentState->upvote < $upvote ){
          $res = $this->WvPost->changeUpvotes( $currentState->post_id, 1 );
        } elseif ( $currentState->upvote > $upvote ){
          $res = $this->WvPost->changeUpvotes( $currentState->post_id, -1 );
        }
        $currentState->upvote = $upvote;
        if( $postData['upvote'] > 0 || $postData['downvote'] < 0 ){
          $currentState->downvote = 0;
        } else if ( $postData['downvote'] > 0 ) {
          $currentState->downvote = 1;
        }
        $keys = array( 'bookmark', 'flag', 'eyewitness' );
        foreach( $keys as $key ){
          if( $postData[ $key ] > 0 ){
            $currentState[ $key ] = 1;
          } else if( $postData[ $key ] < 0 ){
            $currentState[ $key ] = 0;
          }
        }
        if( $postData['shares'] > 0 ){
          $currentState->shares = $currentState->shares + 1;
        }
        $data = array(
          'id' => $currentState->id,
          'user_id' => $currentState->user_id,
          'post_id' => $currentState->post_id,
          'upvote' => $currentState->upvote,
          'downvote' => $currentState->downvote,
          'bookmark' => $currentState->bookmark,
          'flag' => $currentState->flag,
          'eyewitness' => $currentState->eyewitness,
          'shares' => $currentState->shares,
          'modified' => date("Y-m-d H:i:s", time())
        );
      }
      return $data;
    }

    public function conditionBasedSearch( $queryConditions = array() ){
      $response = array();
      if( !empty( $queryConditions ) ){
        $activities = $this->find();
        if( isset( $queryConditions['page'] ) )
          $activities = $activities->page( $queryConditions['page'] );
        if( isset( $queryConditions['offset'] ) )
          $activities = $activities->limit( $queryConditions['offset'] );
        if( isset( $queryConditions['conditions'] ) )
          $activities = $activities->where( $queryConditions['conditions'] );
        $activities = $activities->toArray();
        if( !empty( $activities ) ){
          $postIds = Hash::extract( $activities, '{n}.post_id' );
          $wvPost = $this->WvPost->find()->where(['id IN' => $postIds ])->toArray();
          $response = $wvPost;
        }
      }
      return $response;
    }

    public function getBookMarkCount( $userId = null, $queryConditions = array() ){
      $response = null;
      if( $userId != null ){
        $post = TableRegistry::get('WvActivitylog');
        $conditions = array( 'user_id' => $userId );
        $query = $post->find();
        // if( !empty( $queryConditions ) ){
        //
        // }
        $query = $query->where( $conditions );
        $totalPosts = $query->count();
        $response = $totalPosts;
      }
      return $response;
    }
}
