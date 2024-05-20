<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EventManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Event type enum.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class EventType extends Enum
{
    public const DEFAULT = 0;

    public const COURSE = 1;

    public const EVENT = 2;

    public const FAIR = 3;

    public const CONGRESS = 4;

    public const DEMO = 5;

    public const CONFERENCE = 6;

    public const SEMINAR = 7;

    public const MEETING = 8;

    public const TRADESHOW = 9;

    public const LAUNCH = 10;

    public const CELEBRATION = 11;
}
