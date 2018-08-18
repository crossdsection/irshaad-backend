<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * WvAreaRatings Model
 *
 * @property \App\Model\Table\AreaLevelsTable|\Cake\ORM\Association\BelongsTo $AreaLevels
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\WvAreaRating get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvAreaRating newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvAreaRating[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvAreaRating|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvAreaRating|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvAreaRating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvAreaRating[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvAreaRating findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WvAreaRatingsTable extends Table
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

        $this->setTable('wv_area_ratings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('HashId', ['field' => array( 'user_id', 'area_level_id' ) ]);

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
            ->scalar('area_level')
            ->requirePresence('area_level', 'create')
            ->notEmpty('area_level');

        $validator
            ->requirePresence('good', 'create')
            ->notEmpty('good');

        $validator
            ->requirePresence('bad', 'create')
            ->notEmpty('bad');

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
        // $rules->add($rules->existsIn(['area_level_id'], 'AreaLevels'));
        // $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function saveratings( $saveData = array() ){
      $return = false;
      if( !empty( $saveData ) ){
        $areaRate = TableRegistry::get('WvAreaRatings');
        $query = $areaRate->find('all')->where([
          'user_id' => $saveData['user_id'],
          'area_level_id' => $saveData['area_level_id'],
          'area_level' => $saveData['area_level'],
          'modified BETWEEN NOW() -INTERVAL 1 DAY AND NOW()'
        ]);
        $entity = $query->first();
        if( !empty( $entity ) ){
          return $return;
        } else {
          $entity = $areaRate->newEntity();
          $entity = $areaRate->patchEntity( $entity, $saveData );
          $entity = $this->fixEncodings( $entity );
        }
        try {
          $record = $areaRate->save( $entity );
          if( isset( $record->id ) ){
            $return = $this->encodeResultSet( $record );
          }
        } catch (\PDOException $e) {
          return $return;
        }
      }
      return $return;
    }

    public function getRatings( $areaLevel = null, $areaLevelId = null, $userId = null ){
      $response = array( 'areaLevel' => $areaLevel, 'areaLevelId' => $areaLevelId, 'goodPercent' => 0, 'badPercent' => 0, 'userStatus' => false );
      if( ( $areaLevelId != null && $areaLevel != null ) || ( $areaLevelId == 0 && $areaLevel == 'world' ) ){
        $areaRating = $this->find('all')->where([
          'area_level' => $areaLevel,
          'area_level_id' => $areaLevelId,
          'modified BETWEEN NOW() -INTERVAL 1 DAY AND NOW()'
        ]);
        $totalCount = 0; $goodCount = 0; $badCount = 0; $userStatus = false;
        $goodPercent = 0; $badPercent = 0;
        foreach( $areaRating as $key => $rating ){
          if( $rating->good > 0 ){
            $goodCount++;
            $totalCount++;
          }
          if( $rating->bad > 0 ){
            $badCount++;
            $totalCount++;
          }
          if( $userId == $rating->user_id )
            $userStatus = true;
        }
        if( $totalCount != 0 ){
          $goodPercent = round( $goodCount * 100 / $totalCount );
          $badPercent = round( $badCount * 100 / $totalCount );
        }
        $response = array(
          'areaLevel' => $areaLevel,
          'areaLevelId' => $areaLevelId,
          'goodPercent' => $goodPercent,
          'badPercent' => $badPercent,
          'userStatus' => $userStatus
        );
      }
      return $response;
    }

    public function getDateWiseRatings( $param ){
      $response = array();
      if( ( $param['areaLevelId'] != null && $param['areaLevel'] != null ) || ( $param['areaLevelId'] == 0 && $param['areaLevel'] == 'world' ) ){
        $areaRating = $this->find('all')->where([
          'area_level' => $param['areaLevel'],
          'area_level_id' => $param['areaLevelId'],
          'modified BETWEEN NOW() - INTERVAL 7 DAY AND NOW()'
        ])->toArray();
        if( !empty( $areaRating ) ){
          foreach( $areaRating as $key => $areaRate ){
            $created = $areaRate->created->i18nFormat('yyyy-MM-dd');
            if( !isset( $response[ $created ] ) ){
              $response[ $created ] = array( 'goodPercent' => 0, 'badPercent' => 0, 'goodCount' => 0, 'badCount' => 0, 'totalCount' => 0 );
            }
            if( $areaRate->good > 0 ){
              $response[ $created ]['goodCount']++;
              $response[ $created ]['totalCount']++;
            }
            if( $areaRate->bad > 0 ){
              $response[ $created ]['badCount']++;
              $response[ $created ]['totalCount']++;
            }
            if( $response[ $created ]['totalCount'] > 0 ){
              $response[ $created ]['goodPercent'] = round( $response[ $created ]['goodCount'] * 100 / $response[ $created ]['totalCount'] );
              $response[ $created ]['badPercent'] = round( $response[ $created ]['badCount'] * 100 / $response[ $created ]['totalCount'] );
            }
          }
        }
      }
      return $response;
    }
}
