<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * Polls Model
 *
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\Poll get($primaryKey, $options = [])
 * @method \App\Model\Entity\Poll newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Poll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Poll|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Poll|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Poll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Poll[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Poll findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PollsTable extends Table
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

        $this->setTable('polls');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('ArrayOps');
        $this->addBehavior('HashId', ['field' => array( 'post_id' ) ]);

        $this->belongsTo('Post', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('UserPolls');
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
            ->scalar('title')
            ->maxLength('title', 50)
            ->requirePresence('title', 'create')
            ->notEmpty('title');
        //
        // $validator
        //     ->integer('count')
        //     ->requirePresence('count', 'create')
        //     ->notEmpty('count');

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
        // $rules->add($rules->existsIn(['post_id'], 'Post'));

        return $rules;
    }

    public function savePolls( $data ){
      $return = false;
      if( !empty( $data ) ){
        $createData = array();
        $postId = $data['post_id'];
        foreach( $data['polls'] as $key => $value ){
          if( strlen( $value ) > 0 )
            $createData[] = array( 'post_id' => $postId, 'title' => $value );
        }
        $polls = TableRegistry::get('Polls');
        $entities = $polls->newEntities( $createData );
        if( $polls->saveMany( $entities ) ){
          $return = true;
        }
      }
      return $return;
    }

    /*
     * data['poll_id']
     */
    public function newVote( $data ){
      $return = false;
      if( !empty( $data ) ){
        $polls = TableRegistry::get('Polls');
        $entity = $polls->get( $data['poll_id'] );
        $entity->count++;
        $entity = $this->fixEncodings( $entity );
        if( $polls->save( $entity ) ){
          $return = true;
        }
      }
      return $return;
    }

    public function getPolls( $postIds, $userId = null ){
      $response = array();
      if( !empty( $postIds ) ){
        $pollsData = $this->find('all')->select([ 'title', 'id', 'count', 'post_id' ])->where([ 'post_id IN' => $postIds ])->toArray();
        $pollsData = Hash::combine( $pollsData, '{n}.id', '{n}', '{n}.post_id');
        $userPollData = $this->UserPolls->getUserlistPolled( $postIds );
        foreach( $pollsData as $postId => $polls ){
          if( !isset( $response[ $postId ]  ) ){
            $response[ $postId ] = array( 'polls' => array(), 'userPollStatus' => false );
          }
          $totalPollCount = 0;
          foreach( $polls as $poll ){
            $totalPollCount += $poll['count'];
          }
          foreach( $polls as $poll ){
            if( !isset( $poll['percent'] ) && $totalPollCount != 0 ){
              $poll['percent'] = number_format( ( $poll['count'] / $totalPollCount ) * 100, 2 ) . '%';
            } else {
              $poll['percent'] = 0;
            }
          }
          $userPollStatus = false;
          if( $userId != null && isset( $userPollData[ $postId ] ) && in_array( $userId, $userPollData[ $postId ] ) )
            $userPollStatus = true;
          $response[ $postId ] = array( 'polls' => array_values( $polls ), 'userPollStatus' => $userPollStatus );
        }
        foreach( $postIds as $postId ){
          if( !isset( $response[ $postId ] ) ){
            $response[ $postId ] = array( 'polls' => array(), 'userPollStatus' => false );
          }
        }
      }
      return $response;
    }
}
