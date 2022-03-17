<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use Modules\EventManagement\Controller\BackendController;
use Modules\EventManagement\Models\PermissionCategory;
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
                'state'  => PermissionCategory::EVENT,
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
                'state'  => PermissionCategory::EVENT,
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
                'state'  => PermissionCategory::EVENT,
            ],
        ],
    ],
];
