<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AreaRating Entity
 *
 * @property int $id
 * @property int $area_level_id
 * @property int $user_id
 * @property int $good
 * @property int $bad
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\AreaLevel $area_level
 * @property \App\Model\Entity\User $user
 */
class AreaRating extends Entity
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
        'area_level' => true,
        'area_level_id' => true,
        'user_id' => true,
        'good' => true,
        'bad' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
