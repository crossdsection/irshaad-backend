<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvVotesReview Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $ministry_id
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $locality_name
 * @property bool $vote_status
 * @property int $votes_level_determine_flag
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Ministry $ministry
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 */
class WvVotesReview extends Entity
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
        'ministry_id' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'locality_name' => true,
        'vote_status' => true,
        'votes_level_determine_flag' => true,
        'user' => true,
        'ministry' => true,
        'country' => true,
        'state' => true,
        'city' => true
    ];
}
