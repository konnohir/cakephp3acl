<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Auth;

use Acl\Auth\BaseAuthorize;
use Cake\Http\ServerRequest;

class RoleBasedAuthorize extends BaseAuthorize
{

    /**
     * Checks user authorization using a controller callback.
     *
     * @param array|\ArrayAccess $user Active user data
     * @param \Cake\Http\ServerRequest $request Request instance.
     * @return bool
     */
    public function authorize($user, ServerRequest $request)
    {
        $Acl = $this->_registry->load('Acl');
        $role = [
            'Roles' => [
                'id' => $user['role_id']
            ]
        ];

        return $Acl->check($role, $this->action($request));
    }
}
