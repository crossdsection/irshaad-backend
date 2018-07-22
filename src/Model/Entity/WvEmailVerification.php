<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WvEmailVerification Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $code
 * @property \Cake\I18n\FrozenTime $expirationtime
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\WvUser $wv_user
 */
class WvEmailVerification extends Entity
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
        'token' => true,
        'code' => true,
        'expirationtime' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'wv_user' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
