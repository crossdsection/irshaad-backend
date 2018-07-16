<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvUserPoll Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $poll_id
 * @property int $post_id
 * @property string $latitude
 * @property string $longitude
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Poll $poll
 * @property \App\Model\Entity\Post $post
 */
class WvUserPoll extends Entity
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
        'poll_id' => true,
        'post_id' => true,
        'latitude' => true,
        'longitude' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'poll' => true,
        'post' => true
    ];
}
