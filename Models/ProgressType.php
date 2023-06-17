<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\EventManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Progress type enum.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class ProgressType extends Enum
{
    public const MANUAL = 1;

    public const LINEAR = 2;

    public const EXPONENTIAL = 3;

    public const LOG = 4;

    public const TASKS = 5;
}
