<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvComment Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $text
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Post $post
 */
class WvComment extends Entity
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
        'post_id' => true,
        'text' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'post' => true
    ];
}
