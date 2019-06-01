<?php
namespace App\Model\Entity;

use App\Model\Entity\BaseEntity as Entity;

/**
 * Role Entity
 */
class Role extends Entity
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
        'name' => true,
        'description' => true,
        'users' => true,
        'role_details' => true,
        'aro' => true
    ];
    
    public function parentNode() {
        return null;
    }
}
