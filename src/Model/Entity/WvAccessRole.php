<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvAccessRole Entity
 *
 * @property int $id
 * @property string $name
 * @property int $area_level_id
 * @property int $access_level
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\AreaLevel $area_level
 */
class WvAccessRole extends Entity
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
        'area_level' => true,
        'area_level_id' => true,
        'access_level' => true,
        'created' => true,
        'modified' => true
    ];
}
