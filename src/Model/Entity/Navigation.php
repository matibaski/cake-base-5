<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Navigation Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property string|null $icon
 * @property string|null $title
 * @property string|null $link
 *
 * @property \App\Model\Entity\Navigation $parent_navigation
 * @property \App\Model\Entity\Navigation[] $child_navigations
 */
class Navigation extends Entity
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
        'icon' => true,
        'title' => true,
        'link' => true,
    ];
}
