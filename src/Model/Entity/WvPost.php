<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvPost Entity
 *
 * @property int $id
 * @property int $cat_id
 * @property int $subcat_id
 * @property int $ministry_id
 * @property int $user_id
 * @property int $total_likes
 * @property int $total_comments
 * @property string $title
 * @property string $details
 * @property string $filelink
 * @property \Cake\I18n\FrozenTime $posttime
 * @property bool $poststatus
 * @property string $location
 * @property string $latitude
 * @property string $longitude
 * @property int $type_flag
 * @property string $country_id
 * @property string $state_id
 * @property string $city_id
 * @property string $locality_id
 *
 * @property \App\Model\Entity\Cat $cat
 * @property \App\Model\Entity\Subcat $subcat
 * @property \App\Model\Entity\Ministry $ministry
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Locality $locality
 */
class WvPost extends Entity
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
        'cat_id' => true,
        'subcat_id' => true,
        'ministry_id' => true,
        'user_id' => true,
        'total_likes' => true,
        'total_comments' => true,
        'title' => true,
        'details' => true,
        'filelink' => true,
        'posttime' => true,
        'poststatus' => true,
        'location' => true,
        'latitude' => true,
        'longitude' => true,
        'type_flag' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'locality_id' => true,
        'cat' => true,
        'subcat' => true,
        'ministry' => true,
        'user' => true,
        'country' => true,
        'state' => true,
        'city' => true,
        'locality' => true
    ];
}
