<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

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
            ->boolean('upvote')
            ->requirePresence('upvote', 'create')
            ->notEmpty('upvote');

        $validator
            ->boolean('downvote')
            ->requirePresence('downvote', 'create')
            ->notEmpty('downvote');

        $validator
            ->boolean('bookmark')
            ->requirePresence('bookmark', 'create')
            ->notEmpty('bookmark');

        $validator
            ->integer('shares')
            ->requirePresence('shares', 'create')
            ->notEmpty('shares');

        $validator
            ->scalar('flag')
            ->requirePresence('flag', 'create')
            ->notEmpty('flag');

        $validator
            ->boolean('eyewitness')
            ->requirePresence('eyewitness', 'create')
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
        $record = $activity->save( $entity );
        if( $record->id ){
          $return = true;
        }
      }
      return $return;
    }

    public function getCumulativeResult( $postIds = array() ){
      $data = array();
      if( !empty( $postIds ) ){
        $tableData = $this->find('all')->where([ 'post_id IN' => $postIds ])->toArray();
        foreach ( $postIds as $key => $postId ) {
          if( !isset( $data[ $postId ] ) ){
            $data[ $postId ] = array( 'upvotes' => 0, 'downvotes' => 0, 'eyewitness' => 0 );
          }
        }
        foreach( $tableData as $key => $value ){
          if( $value->upvote > 0 )
            $data[ $value->post_id ]['upvotes'] = $data[ $value->post_id ]['upvotes'] + 1;
          if( $value->downvote > 0 )
            $data[ $value->post_id ]['downvotes'] = $data[ $value->post_id ]['downvotes'] + 1;
          if( $value->eyewitness > 0 )
            $data[ $value->post_id ]['eyewitness'] = $data[ $value->post_id ]['eyewitness'] + 1;
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
        if( $postData['upvote'] < 0 || $postData['downvote'] > 0 ){
          $currentState->upvote = 0;
        } else if ( $postData['upvote'] > 0 ) {
          $currentState->upvote = 1;
        }
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
}
