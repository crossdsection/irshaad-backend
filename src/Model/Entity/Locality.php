<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Locality Entity
 *
 * @property int $id
 * @property string $locality
 * @property int $city_id
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\City $city
 */
class Locality extends Entity
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
        'id' => true,
        'locality' => true,
        'city_id' => true,
        'active' => true,
        'latitude' => true,
        'longitude' => true,
        'created' => true,
        'modified' => true,
        'city' => true
    ];
}
