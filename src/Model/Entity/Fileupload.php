<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Fileupload Entity
 *
 * @property int $id
 * @property string $filepath
 * @property string $filletype
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Fileupload extends Entity
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
        'filepath' => true,
        'filetype' => true,
        'created' => true,
        'modified' => true
    ];
}
