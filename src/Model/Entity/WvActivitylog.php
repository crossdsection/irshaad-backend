<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvActivitylog Entity
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property bool $action
 *
 * @property \App\Model\Entity\WvPost $wv_post
 * @property \App\Model\Entity\WvUser $wv_user
 */
class WvActivitylog extends Entity
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
        'post_id' => true,
        'user_id' => true,
        'action' => true,
        'wv_post' => true,
        'wv_user' => true
    ];
}
