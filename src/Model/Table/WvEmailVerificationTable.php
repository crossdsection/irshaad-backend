<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Utility\Hash;

/**
 * WvEmailVerification Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\WvEmailVerification get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvEmailVerification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvEmailVerification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvEmailVerification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvEmailVerification|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvEmailVerification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvEmailVerification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvEmailVerification findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvEmailVerificationTable extends Table
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

        $this->setTable('wv_email_verification');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('GenericOps');
        $this->addBehavior('HashId', ['field' => array( 'user_id' ) ]);

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
            ->scalar('token')
            ->maxLength('token', 36)
            ->requirePresence('token', 'create')
            ->notEmpty('token');

        $validator
            ->scalar('code')
            ->maxLength('code', 10)
            ->requirePresence('code', 'create')
            ->notEmpty('code');
        //
        // $validator
        //     ->dateTime('expirationtime')
        //     ->requirePresence('expirationtime', 'create')
        //     ->notEmpty('expirationtime');
        //
        // $validator
        //     ->requirePresence('status', 'create')
        //     ->notEmpty('status');

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

        return $rules;
    }


    public function add( $userId = null ){
      $response = null;
      if( $userId != null ){
        $data = array(
          'user_id' => $userId,
          'token' => Text::uuid(),
          'code' => $this->randomAlphanumeric( 8 ),
        );
        $emailVerification = TableRegistry::get('WvEmailVerification');
        $entity = $emailVerification->newEntity();
        $entity = $emailVerification->patchEntity( $entity, $data );
        $record = $emailVerification->save( $entity );
        $response = $record;
      }
      return $response;
    }

    /*
     * data[ code ]
     * data[ token ]
     * data[ userId ]
     */
    public function verify( $data = array() ){
      $response = array( 'error' => 1, 'message' => 'Verification Failed', 'data' => array() );
      if( !empty( $data ) ){
        $emailVerification = TableRegistry::get('WvEmailVerification');
        $user = $this->WvUser->find()->where( [ 'email' => $data['email'], 'status' => 1 ] )->toArray();
        if( !empty( $user ) ){
          $founds = $emailVerification->find()->where( [ 'user_id' => $user[0]->id, 'status' => 1 ] )->toArray();
          if( !empty( $founds ) ){
            $userVerified = false;
            foreach( $founds as $found ){
              if( isset( $data['token'] ) && $data['token'] == $found->token ){
                $userVerified = true;
              }
              if( isset( $data['code'] ) && $data['code'] == $found->code ){
                $userVerified = true;
              }
              if( $userVerified ){
                $updateUser = array( $user[0]->id => array( 'id' => $user[0]->id, 'email_verified' => 1 ) );
                $usersUpdated = $this->WvUser->updateUser( $updateUser );
                if( !empty( $usersUpdated ) ){
                  $entity = $emailVerification->get( $found->id );
                  $entity->status = 0;
                  $entity = $this->fixEncodings( $entity );
                  if( $emailVerification->save( $entity ) ){
                    $response = array( 'error' => 0, 'message' => 'Verification Successful', 'data' => array( $user[0]->id ) );
                  }
                }
                break;
              }
            }
          } else {
            $response = array( 'error' => 1, 'message' => 'Invalid Code' );
          }
        } else {
          $response = array( 'error' => 1, 'message' => 'User not found' );
        }
      }
      return $response;
    }
}
