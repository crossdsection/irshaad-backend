<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

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
      $response = array( 'error' => 1, 'message' => 'Verification Failed' );
      if( !empty( $data ) ){
        $emailVerification = TableRegistry::get('WvEmailVerification');
        $found = $emailVerification->find()->where( [ 'user_id' => $data['userId'], 'status' => 1 ] )->toArray();
        if( $found != null ){
          $userVerified = false;
          if( isset( $data['token'] ) && $data['token'] == $found[0]->token ){
            $userVerified = true;
          }
          if( isset( $data['code'] ) && $data['code'] == $found[0]->code ){
            $userVerified = true;
          }
          if( $userVerified ){
            $user = $this->WvUser->getUserList( $data['userId'], array( 'id', 'email_verified' ) );
            $user[ $data['userId'] ]['email_verified'] = 1;
            $usersUpdated = $this->WvUser->updateUser( $user );
            if( !empty( $usersUpdated ) ){
              $entity = $emailVerification->get( $found[0]->id );
              $entity->status = 0;
              if( $emailVerification->save( $entity ) ){
                $response = array( 'error' => 0, 'message' => 'Verification Successful' );
                return $response;
              }
            }
          }
        } else {
          $response = array( 'error' => 1, 'message' => 'No Tokens Available.' );
        }
      }
      return $response;
    }
}
