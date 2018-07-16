<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvPoll Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string $title
 * @property int $count
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Post $post
 */
class WvPoll extends Entity
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
        'title' => true,
        'count' => true,
        'created' => true,
        'modified' => true,
        'post' => true
    ];
}
