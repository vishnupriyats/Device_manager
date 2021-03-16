<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Device Entity
 *
 * @property int $id
 * @property string $browser
 * @property string $os
 * @property string $os_version
 * @property string $model
 * @property int $status
 *
 * @property \App\Model\Entity\User[] $users
 */
class Device extends Entity
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
        'browser' => true,
        'os' => true,
        'os_version' => true,
        'model' => true,
        'status' => true,
        'users' => true,
    ];
    const NEWREQUEST=2;
    const AVAILABLE=1;
    const TAKEN=0;

}
