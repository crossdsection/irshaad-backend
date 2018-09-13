<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activitylog Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property bool $upvote
 * @property bool $downvote
 * @property bool $bookmark
 * @property int $shares
 * @property string $flag
 * @property bool $eyewitness
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Post $post
 */
class Activitylog extends Entity
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
        'upvote' => true,
        'downvote' => true,
        'bookmark' => true,
        'shares' => true,
        'flag' => true,
        'eyewitness' => true,
        'authority_flag' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'post' => true
    ];
}
