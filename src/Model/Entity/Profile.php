<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Profile Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $image_file
 * @property string|null $cover_image
 * @property string|null $street
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $region
 * @property string|null $country
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $website
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Profile extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'image_file' => true,
        'cover_image' => true,
        'street' => true,
        'zip' => true,
        'city' => true,
        'region' => true,
        'country' => true,
        'phone' => true,
        'mobile' => true,
        'website' => true,
        'facebook' => true,
        'instagram' => true,
        'linkedin' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];

    protected $_virtual = ['name'];

    protected function _getName()
    {
        return $this->first_name . '  ' . $this->last_name;
    }
}
