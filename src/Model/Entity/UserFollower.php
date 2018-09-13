<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserFollower Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $followuser_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Followuser $followuser
 */
class UserFollower extends Entity
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
        'followuser_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'followuser' => true
    ];
}
