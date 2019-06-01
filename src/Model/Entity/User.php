<?php
namespace App\Model\Entity;

use App\Model\Entity\BaseEntity as Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 */
class User extends Entity
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
        'role_id' => true,
        'role' => true
    ];

    protected $_hidden = ['password'];

    protected function _setPassword($password) {
        if (strlen($password) > 0) {
          return (new DefaultPasswordHasher)->hash($password);
        }
    }
    
    public function parentNode()
    {
        if (!$this->id) {
            return null;
        }
        if (!isset($this->role_id)) {
            throw new \Exception('undefined role_id');
        }
        if (!$this->role_id) {
            return null;
        }

        return ['Roles' => ['id' => $this->role_id]];
    }
}
