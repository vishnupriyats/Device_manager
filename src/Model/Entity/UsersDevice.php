<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersDevice Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $device_id
 * @property \Cake\I18n\FrozenTime $assigned_date
 * @property \Cake\I18n\FrozenTime $returned_date
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Device $device
 */
class UsersDevice extends Entity
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
        'device_id' => true,
        'assigned_date' => true,
        'returned_date' => true,
        'user' => true,
        'device' => true,
    ];
}
