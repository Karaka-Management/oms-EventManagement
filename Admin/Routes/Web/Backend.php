<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\EventManagement\Controller\BackendController;
use Modules\EventManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/eventmanagement/list(\?.*$|$)' => [
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
    '^/eventmanagement/create(\?.*$|$)' => [
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
    '^/eventmanagement/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EventManagement\Controller\BackendController:viewEventManagementView',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EVENT,
            ],
        ],
    ],
];
