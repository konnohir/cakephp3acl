<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use DateTime;

/**
 * Base Entity
 */
class BaseEntity extends Entity
{
    public function _getUpdatedAt($updated_at) {
        if (empty($updated_at)) {
            return null;
        }
        return $updated_at->format('Y-m-d H:i:s.u');
    }

    public function _setUpdatedAt($updated_at) {
        if (empty($updated_at)) {
            return (new DateTime());
        }
        if (!$updated_at instanceof DateTime) {
            return (new DateTime($updated_at));
        }
        return $updated_at;
    }
}
