<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvMinistry Entity
 *
 * @property int $id
 * @property string $ministry_name
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property bool $ministry_status
 * @property string $ministry_head_profilepic
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 */
class WvMinistry extends Entity
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
        'ministry_name' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'ministry_status' => true,
        'ministry_head_profilepic' => true,
        'country' => true,
        'state' => true,
        'city' => true
    ];
}
