<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property int $to_user_id
 * @property int $from_user_id
 * @property string|null $message
 * @property bool $seen
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $to_user
 * @property \App\Model\Entity\User $from_user
 */
class Message extends Entity
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
        'to_user_id' => true,
        'from_user_id' => true,
        'message' => true,
        'seen' => true,
        'created' => true,
        'to_user' => true,
        'from_user' => true,
    ];
}
