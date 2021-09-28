<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\EventManagement\Controller\BackendController;
use Modules\EventManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/eventmanagement/list.*$' => [
        [
            'dest'       => '\Modules\EventManagement\Controller\BackendController:viewEventManagementList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::EVENT,
            ],
        ],
    ],
    '^.*/eventmanagement/create.*$' => [
        [
            'dest'       => '\Modules\EventManagement\Controller\BackendController:viewEventManagementCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionState::EVENT,
            ],
        ],
    ],
    '^.*/eventmanagement/profile.*$' => [
        [
            'dest'       => '\Modules\EventManagement\Controller\BackendController:viewEventManagementProfile',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::EVENT,
            ],
        ],
    ],
];
