<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * WvPolls Model
 *
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\WvPoll get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvPoll newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvPoll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvPoll|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvPoll|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvPoll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvPoll[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvPoll findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvPollsTable extends Table
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

        $this->setTable('wv_polls');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('ArrayOps');
        $this->addBehavior('HashId', ['field' => array( 'post_id' ) ]);

        $this->belongsTo('WvPost', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('WvUserPolls');
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
        // $rules->add($rules->existsIn(['post_id'], 'WvPost'));

        return $rules;
    }

    public function savePolls( $data ){
      $return = false;
      if( !empty( $data ) ){
        $createData = array();
        $postId = $data['post_id'];
        foreach( $data['polls'] as $key => $value ){
          $createData[] = array( 'post_id' => $postId, 'title' => $value );
        }
        $polls = TableRegistry::get('WvPolls');
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
        $polls = TableRegistry::get('WvPolls');
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
        $userPollData = $this->WvUserPolls->getUserlistPolled( $postIds );
        foreach( $pollsData as $postId => $polls ){
          if( !isset( $response[ $postId ]  ) ){
            $response[ $postId ] = array( 'polls' => array(), 'userPollStatus' => false );
          }
          $userPollStatus = false;
          if( $userId != null && in_array( $userId, $userPollData[ $postId ] ) )
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
