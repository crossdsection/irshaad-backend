<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $department_id
 * @property int $user_id
 * @property int $total_likes
 * @property int $total_comments
 * @property string $title
 * @property string $details
 * @property string $filejson
 * @property bool $poststatus
 * @property string $location
 * @property string $latitude
 * @property string $longitude
 * @property string $country_id
 * @property string $state_id
 * @property string $city_id
 * @property string $locality_id
 * @property string $post_type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Department $department
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Locality $locality
 */
class Post extends Entity
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
        'department_id' => true,
        'user_id' => true,
        'total_upvotes' => true,
        'total_score' => true,
        'title' => true,
        'details' => true,
        'filejson' => true,
        'poststatus' => true,
        'location' => true,
        'latitude' => true,
        'longitude' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'locality_id' => true,
        'post_type' => true,
        'created' => true,
        'modified' => true,
        'department' => true,
        'user' => true,
        'country' => true,
        'state' => true,
        'city' => true,
        'locality' => true
    ];
}
