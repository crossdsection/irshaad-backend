<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvFavLocation Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $department_id
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property int $locality_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\WvUser $wv_user
 * @property \App\Model\Entity\WvDepartment $wv_department
 * @property \App\Model\Entity\WvCountry $wv_country
 * @property \App\Model\Entity\WvState $wv_state
 * @property \App\Model\Entity\WvCity $wv_city
 * @property \App\Model\Entity\WvLocality $wv_locality
 */
class WvFavLocation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'department_id' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'locality_id' => true,
        'created' => true,
        'modified' => true,
        'wv_user' => true,
        'wv_department' => true,
        'wv_country' => true,
        'wv_state' => true,
        'wv_city' => true,
        'wv_locality' => true
    ];
}
