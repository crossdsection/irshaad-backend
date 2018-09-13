<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * Post Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Departments
 * @property |\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Countries
 * @property |\Cake\ORM\Association\BelongsTo $States
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 * @property |\Cake\ORM\Association\BelongsTo $Localities
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostTable extends Table
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

        $this->setTable('post');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('ArrayOps');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'city_id', 'department_id', 'locality_id', 'country_id', 'state_id', 'locality_id' ) ]);

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Localities', [
            'foreignKey' => 'locality_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Activitylog');
        $this->hasOne('Polls');
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
            ->notEmpty('user_id');

        $validator
            ->integer('total_upvotes');

        $validator
            ->integer('total_score');

        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('details')
            // ->maxLength('details', 512)
            ->requirePresence('details', 'create')
            ->notEmpty('details');

        $validator
            ->scalar('filejson')
            ->maxLength('filejson', 512)
            ->requirePresence('filejson', 'create')
            ->notEmpty('filejson');

        $validator
            ->boolean('poststatus')
            ->notEmpty('poststatus');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 100)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 100)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->scalar('post_type')
            ->requirePresence('post_type', 'create')
            ->notEmpty('post_type');

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
        // $rules->add($rules->existsIn(['department_id'], 'Departments'));
        // $rules->add($rules->existsIn(['user_id'], 'User'));
        // $rules->add($rules->existsIn(['country_id'], 'Countries'));
        // $rules->add($rules->existsIn(['state_id'], 'States'));
        // $rules->add($rules->existsIn(['city_id'], 'Cities'));
        // $rules->add($rules->existsIn(['locality_id'], 'Localities'));
        return $rules;
    }

    public function savePost( $postData = array() ){
      $return = false;
      if( !empty( $postData ) ){
        $post = TableRegistry::get('Post');
        $entity = $post->newEntity();
        $entity = $post->patchEntity( $entity, $postData );
        $entity = $this->fixEncodings( $entity );
        $record = $post->save( $entity );
        if( isset( $record->id ) ){
          $return = $record->id;
        }
      }
      return $return;
    }

    public function allowAdmin( $wvPost, $accessRoleIds = array() ){
      $return = false;
      if( !empty( $wvPost ) ){
        $locationTag = array( 'city_id' => array(), 'state_id' => array(), 'country_id' => array());
        $localityCityMap = array(); $accessRoleArr = array();
        if( $wvPost->locality_id != null ){
          $localityRes = $this->Localities->findLocalityById( array( $wvPost->locality_id ) );
          if( !empty( $localityRes['data']['cities'] )){
            $localityCityMap = Hash::combine( $localityRes['data']['localities'], '{n}.locality_id', '{n}.city_id' );
            $cityIds = Hash::extract( $localityRes['data']['cities'], '{n}.city_id' );
            $locationTag['city_id'] = array_merge( $cityIds, $locationTag['city_id'] );
          }
        } else if( $wvPost->city_id != null ){
          $locationTag['city_id'][] = $wvPost->city_id;
        } else if( $wvPost->state_id != null ){
          $locationTag['state_id'][] = $wvPost->state_id;
        } else if( $wvPost->country_id != null ){
          $locationTag['country_id'][] = $wvPost->country_id;
        }
        if( !empty( $locationTag['city_id'] ) || !empty( $locationTag['state_id'] ) || !empty( $locationTag['country_id'] ) ){
          $accessData = $this->User->AccessRoles->retrieveAccessRoleIds( $locationTag );
          $accessRoleArr = Hash::extract( $accessData, '{n}.id' );
          // $accessData = $this->array_group_by( $accessData, 'area_level', 'area_level_id');
        }
        $allowedAccessRoles = array_intersect( $accessRoleArr, (array) $accessRoleIds );
        if( !empty( $allowedAccessRoles ) ){
          $return = true;
        }
      }
      return $return;
    }

    public function retrievePostDetailed( $wvPost, $userId = null, $accessRoleIds = array() ){
      $fileuploadIds = array(); $userIds = array(); $postIds = array();
      $localityIds = array(); $localityCityMap = array();
      $data = array();
      if( !empty( $wvPost ) ){
        $locationTag = array( 'city_id' => array(), 'state_id' => array(), 'country_id' => array());
        foreach ( $wvPost as $key => $value ) {
          $fileuploadIds = array_merge( $fileuploadIds, json_decode( $value['filejson'] ) );
          $userIds[] = $value->user_id;
          $postIds[] = $value->id;
          if( $value->locality_id != null )
            $localityIds[] = $value->locality_id;
          if( $value->city_id != null )
            $locationTag['city_id'][] = $value->city_id;
          if( $value->state_id != null )
            $locationTag['state_id'][] = $value->state_id;
          if( $value->country_id != null )
            $locationTag['country_id'][] = $value->country_id;
        }
        $this->Fileuploads = TableRegistry::get('Fileuploads');
        $fileResponse = $this->Fileuploads->getfileurls( $fileuploadIds );
        $userInfos = $this->User->getUserList( $userIds );
        $postProperties = $this->Activitylog->getCumulativeResult( $postIds, $userId );
        $postPolls = $this->Polls->getPolls( $postIds, $userId );
        if( !empty( $localityIds ) ){
          $localityRes = $this->Localities->findLocalityById( $localityIds );
          if( !empty( $localityRes['data']['cities'] )){
            $localityCityMap = Hash::combine( $localityRes['data']['localities'], '{n}.locality_id', '{n}.city_id' );
            $cityIds = Hash::extract( $localityRes['data']['cities'], '{n}.city_id' );
            $locationTag['city_id'] = array_merge( $cityIds, $locationTag['city_id'] );
          }
        }
        if( !empty( $locationTag['city_id'] ) || !empty( $locationTag['state_id'] ) || !empty( $locationTag['country_id'] ) ){
          $locationTag['city_id'] = array_unique( $locationTag['city_id'] );
          $locationTag['state_id'] = array_unique( $locationTag['state_id'] );
          $locationTag['country_id'] = array_unique( $locationTag['country_id'] );
          $accessData = $this->User->AccessRoles->retrieveAccessRoleIds( $locationTag );
          $accessData = $this->array_group_by( $accessData, 'area_level', 'area_level_id');
        }
        foreach ( $wvPost as $key => $value ) {
          if( $value['user_id'] == null ){
            continue;
          }
          $accessRoleId = 0; $accessRoleArr = array();
          if( $value->locality_id != null ){
            $cityId = $localityCityMap[ $value->locality_id ];
            $accessRoleArr = $accessData['city'][ $cityId ];
          } else if( $value->city_id != null ){
            $accessRoleArr = $accessData['city'][ $value->city_id ];
          } else if( $value->state_id != null ){
            $accessRoleArr = $accessData['state'][ $value->state_id ];
          } else if( $value->country_id != null ){
            $accessRoleArr = $accessData['country'][ $value->country_id ];
          }
          $permission = array( 'userEnablePole' => false, 'adminEnableAccept' => false );
          foreach( $accessRoleArr as $accessRole ){
            if( $accessRole['id'] != null && in_array( $accessRole['id'], (array) $accessRoleIds ) ){
              if( $accessRole['access_level'] >= 1 ){
                $permission['userEnablePole'] = 1;
              }
              if( $accessRole['access_level'] == 2 ){
                $permission['adminEnableAccept'] = 1;
                break;
              }
            }
          }
          if( !empty( $fileResponse['data']  ) ){
            $fileJSON = json_decode( $value->filejson );
            $value['files'] = array( 'images' => array(), 'attachments' => array() );
            foreach( $fileJSON as $key => $id ){
              if( isset( $fileResponse['data'][ $id ] ) ){
                if( strpos( $fileResponse['data'][ $id ]['filetype'], 'image' ) !== false ){
                  $value['files']['images'][] = $fileResponse['data'][ $id ];
                } else {
                  $value['files']['attachments'][] = $fileResponse['data'][ $id ];
                }
              }
            }
          }
          $value['props'] = array(); $value['polls'] = array();
          if( isset( $postProperties[ $value['id'] ] ) ){
            $value['props'] = $postProperties[ $value['id'] ];
          }
          if( isset( $postPolls[ $value['id'] ] ) ){
            $value['polls'] = $postPolls[ $value['id'] ];
          }
          $value['permissions'] = $permission;
          unset( $value['filejson'] );
          $value['user'] = $userInfos[ $value['user_id'] ];
          unset( $value['user_id'] );
          $data[] = $value;
        }
      }
      return $data;
    }

    public function changeUpvotes( $postId = null, $change = null ){
      $response = false;
      if( $postId != null && $change != null ){
        $post = TableRegistry::get('Post');
        $entity = $post->get( $postId );
        $entity->total_upvotes = $entity->total_upvotes + $change;
        if( $post->save( $entity ) ){
          $response = true;
        }
      }
      return $response;
    }

    public function getUserPostCount( $userId = null, $queryConditions = array() ){
      $response = null;
      if( $userId != null ){
        $post = TableRegistry::get('Post');
        $conditions = array( 'user_id' => $userId );
        $query = $post->find();
        if( !empty( $queryConditions ) ){
          if( $queryConditions['poststatus'] == 0 ){
            $conditions[] = array( 'poststatus' => 0 );
          } else {
            $conditions[] = array( 'poststatus' => 1 );
          }
        }
        $query = $query->where( $conditions );
        $totalPosts = $query->count();
        $response = $totalPosts;
      }
      return $response;
    }
}
