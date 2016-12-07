<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Modules\EventManagement\Models;

use phpOMS\Datatypes\Enum;

/**
 * Event type enum.
 *
 * @category   Calendar
 * @package    Modules
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class EventType extends Enum
{
    /* public */ const DEFAULT = 0;

    /* public */ const COURSE = 1;

    /* public */ const EVENT = 2;

    /* public */ const FAIR = 3;

    /* public */ const CONGRESS = 4;

    /* public */ const DEMO = 5;

    /* public */ const CONFERENCE = 6;

    /* public */ const SEMINAR = 7;

    /* public */ const MEETING = 8;

    /* public */ const TRADESHOW = 9;

    /* public */ const LAUNCH = 10;

    /* public */ const CELEBRATION = 11;
}
