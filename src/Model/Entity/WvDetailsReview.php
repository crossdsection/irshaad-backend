<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvDetailsReview Entity
 *
 * @property int $id
 * @property bool $country_id
 * @property int $review_flag
 * @property \Cake\I18n\FrozenTime $date_time
 * @property int $city_id
 * @property int $locality_id
 * @property int $total_good_reviews
 * @property int $total_bad_reviews
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Locality $locality
 */
class WvDetailsReview extends Entity
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
        'country_id' => true,
        'review_flag' => true,
        'date_time' => true,
        'city_id' => true,
        'locality_id' => true,
        'total_good_reviews' => true,
        'total_bad_reviews' => true,
        'country' => true,
        'city' => true,
        'locality' => true
    ];
}
