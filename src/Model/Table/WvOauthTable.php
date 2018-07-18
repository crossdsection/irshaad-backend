<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Firebase\JWT\JWT;

/**
 * WvOauth Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProvidersTable|\Cake\ORM\Association\BelongsTo $Providers
 *
 * @method \App\Model\Entity\WvOauth get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvOauth newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvOauth[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvOauth|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvOauth|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvOauth patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvOauth[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvOauth findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvOauthTable extends Table
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

        $this->setTable('wv_oauth');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('WvUser', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        // $this->belongsTo('Providers', [
        //     'foreignKey' => 'provider_id',
        //     'joinType' => 'INNER'
        // ]);
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
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');

        $validator
            ->scalar('access_token')
            ->maxLength('access_token', 2048)
            ->requirePresence('access_token', 'create')
            ->notEmpty('access_token');

        $validator
            ->requirePresence('expiration_time', 'create')
            ->notEmpty('expiration_time');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'WvUser'));
        // $rules->add($rules->existsIn(['provider_id'], 'Providers'));

        return $rules;
    }

    public function matchAndRetrieve( $access_token ){
        return true;
    }

    public function getUserToken( $userId ){
      $result = array( 'error' => 0, 'data' => array());
      if( $userId != 0 ){
        $extractedData = $this->find()->where([ 'user_id' => $userId ])->toArray();
        if( !empty( $extractedData ) && strtotime( $extractedData[0]['expiration_time'] ) > time() ){
          $user = $this->WvUser->find()->where( [ 'id' => $userId ] )->toArray();
          $secretKey = Configure::read('jwt_secret_key');
          $data = [
             'issued_at'  => $extractedData[0]['issued_at'],         // Issued at: time when the token was generated
             'access_token'  => $extractedData[0]['access_token'],          // Json Token Id: an unique identifier for the token
             'provider_id'  => $extractedData[0]['provider_id'],       // Issuer
             'expiration_time'  => $extractedData[0]['expiration_time']->toUnixString(),           // Expire
             'user_id' => $userId
          ];
          $bearerToken = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
          );
          $response = array(
            'name' => $user[0]->firstname.' '.$user[0]->lastname,
            'access_roles' => json_decode( $user[0]->access_role_ids ),
            'bearerToken' => $bearerToken
          );
          $result['data'] = $response;
        } else if( !empty( $extractedData ) ) {
          $result['error'] = -1;
        } else {
          $result['error'] = 1;
        }
      } else {
        $result['error'] = 1;
      }
      return $result;
    }

    public function createUserToken( $userId ){
      $result = array( 'error' => 0, 'data' => array());
      if( $userId != 0 ){
        $user = $this->WvUser->find()->where( [ 'id' => $userId ] )->toArray();
        $serverName = Configure::read('App.fullBaseUrl');
        $secretKey = Configure::read('jwt_secret_key');
        $tokenId   = base64_encode( Security::randomBytes( 32 ) );
        $issuedAt = time();
        $expire = $issuedAt + 86400;
        $data = [
           'issued_at'  => $issuedAt,         // Issued at: time when the token was generated
           'access_token'  => $tokenId,          // Json Token Id: an unique identifier for the token
           'provider_id'  => $serverName,       // Issuer
           'expiration_time'  => $expire,           // Expire
           'user_id' => $userId
        ];

        $bearerToken = JWT::encode(
          $data,      //Data to be encoded in the JWT
          $secretKey, // The signing key
          'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        $oAuth = TableRegistry::get('WvOauth');
        $oEntity = $oAuth->newEntity();
        $oEntity = $oAuth->patchEntity( $oEntity, $data );
        if( $oAuth->save( $oEntity ) ){
          $response = array(
            'name' => $user[0]->firstname.' '.$user[0]->lastname,
            'access_roles' => json_decode( $user[0]->access_role_ids ),
            'bearerToken' => $bearerToken
          );
          $result['data'] = $response;
        } else {
          $result['error'] = 1;
        }
      } else {
        $result['error'] = 1;
      }
      return $result;
    }

    public function refreshAccessToken( $userId ){
      $result = array( 'error' => 0, 'data' => array());
      if( $userId != 0 ){
        $user = $this->WvUser->find()->where( [ 'id' => $userId ] )->toArray();
        $extractedData = $this->find()->where([ 'user_id' => $userId ])->toArray();

        $serverName = Configure::read('App.fullBaseUrl');
        $secretKey = Configure::read('jwt_secret_key');
        $tokenId   = base64_encode( Security::randomBytes( 32 ) );
        $issuedAt = time();
        $expire = $issuedAt + 86400;

        $data = [
           'issued_at'  => $issuedAt,         // Issued at: time when the token was generated
           'access_token'  => $tokenId,          // Json Token Id: an unique identifier for the token
           'provider_id'  => $serverName,       // Issuer
           'expiration_time'  => $expire,           // Expire
           'user_id' => $userId
        ];

        $bearerToken = JWT::encode(
          $data,      //Data to be encoded in the JWT
          $secretKey, // The signing key
          'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        $saveData = $data;
        $saveData['modified'] = $data['issued_at'];

        $oAuth = TableRegistry::get('WvOauth');
        $oEntity = $oAuth->get( $extractedData[0]->id );
        $oEntity = $oAuth->patchEntity( $oEntity, $saveData );
        if( $oAuth->save( $oEntity ) ){
          $response = array(
            'name' => $user[0]->firstname.' '.$user[0]->lastname,
            'access_roles' => json_decode( $user[0]->access_role_ids ),
            'bearerToken' => $bearerToken
          );
          $result['data'] = $response;
        } else {
          $result['error'] = 1;
        }
      } else {
        $result['error'] = 1;
      }
      return $result;
    }

    public function validateToken( $token ){
      $result = false;
      if( !empty( $token ) && isset( $token->user_id ) && isset( $token->access_token ) ){
        $extractedData = $this->find()->where([ 'user_id' => $token->user_id, 'access_token' => $token->access_token ])->toArray();
        if( !empty( $extractedData ) && $token->expiration_time >= time() ){
          return true;
        }
      }
      return $result;
    }
}
