<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WvCountries Model
 *
 * @method \App\Model\Entity\WvCountry get($primaryKey, $options = [])
 * @method \App\Model\Entity\WvCountry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WvCountry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WvCountry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WvCountry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WvCountry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WvCountry findOrCreate($search, callable $callback = null, $options = [])
 */
class WvCountriesTable extends Table
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

        $this->setTable('wv_countries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->scalar('sortname')
            ->maxLength('sortname', 3)
            ->requirePresence('sortname', 'create')
            ->notEmpty('sortname');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('phonecode')
            ->requirePresence('phonecode', 'create')
            ->notEmpty('phonecode');

        return $validator;
    }
}
