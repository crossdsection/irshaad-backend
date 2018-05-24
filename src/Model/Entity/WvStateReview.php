<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvStateReview Entity
 *
 * @property int $id
 * @property int $state_id
 * @property bool $review_flag
 * @property int $date_time
 *
 * @property \App\Model\Entity\State $state
 */
class WvStateReview extends Entity
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
        'state_id' => true,
        'review_flag' => true,
        'date_time' => true,
        'state' => true
    ];
}
