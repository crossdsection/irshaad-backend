<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvUser Entity
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $gender
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $profilepic
 * @property bool $status
 * @property bool $active
 * @property bool $email_verified
 * @property int $adhar_verified
 * @property int $authority_flag
 * @property string $access_role_ids
 * @property string $rwa_name
 * @property int $department_id
 * @property string $designation
 * @property string $certificate
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class WvUser extends Entity
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
        'firstname' => true,
        'lastname' => true,
        'gender' => true,
        'email' => true,
        'password' => true,
        'phone' => true,
        'address' => true,
        'latitude' => true,
        'longitude' => true,
        'profilepic' => true,
        'status' => true,
        'active' => true,
        'email_verified' => true,
        'adhar_verified' => true,
        'authority_flag' => true,
        'access_role_ids' => true,
        'rwa_name' => true,
        'department_id' => true,
        'designation' => true,
        'certificate' => true,
        'country_id' => true,
        'state_id' => true,
        'city_id' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
