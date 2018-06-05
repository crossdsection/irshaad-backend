<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvDepartment Entity
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property bool $status
 * @property string $head_profilepic
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\WvCountry $wv_country
 * @property \App\Model\Entity\WvState $wv_state
 * @property \App\Model\Entity\WvCity $wv_city
 */
class WvDepartment extends Entity
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
        'name' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'status' => true,
        'head_profilepic' => true,
        'created' => true,
        'modified' => true,
        'wv_country' => true,
        'wv_state' => true,
        'wv_city' => true
    ];
}
