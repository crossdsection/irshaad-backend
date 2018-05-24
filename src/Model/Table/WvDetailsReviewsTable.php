<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WvDetailsReviews Model
 *
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\LocalitiesTable|\Cake\ORM\Association\BelongsTo $Localities
 *
 * @method \App\Model\Entity\WvDetailsReview get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvDetailsReview newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvDetailsReview[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvDetailsReview|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvDetailsReview patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvDetailsReview[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvDetailsReview findOrCreate($search, callable $callback = null, $options = [])
 */
class WvDetailsReviewsTable extends Table
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

        $this->setTable('wv_details_reviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('Localities', [
            'foreignKey' => 'locality_id'
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
            ->integer('review_flag')
            ->requirePresence('review_flag', 'create')
            ->notEmpty('review_flag');

        $validator
            ->dateTime('date_time')
            ->requirePresence('date_time', 'create')
            ->notEmpty('date_time');

        $validator
            ->integer('total_good_reviews')
            ->allowEmpty('total_good_reviews');

        $validator
            ->integer('total_bad_reviews')
            ->allowEmpty('total_bad_reviews');

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
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['locality_id'], 'Localities'));

        return $rules;
    }
}
