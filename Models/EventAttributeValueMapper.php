<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\EventManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Event mapper class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class EventAttributeValueMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'eventmanagement_event_attr_value_id'       => ['name' => 'eventmanagement_event_attr_value_id',       'type' => 'int',    'internal' => 'id'],
        'eventmanagement_event_attr_value_default'  => ['name' => 'eventmanagement_event_attr_value_default',  'type' => 'bool', 'internal' => 'isDefault'],
        'eventmanagement_event_attr_value_type'     => ['name' => 'eventmanagement_event_attr_value_type',     'type' => 'int',    'internal' => 'type'],
        'eventmanagement_event_attr_value_valueStr' => ['name' => 'eventmanagement_event_attr_value_valueStr', 'type' => 'string', 'internal' => 'valueStr'],
        'eventmanagement_event_attr_value_valueInt' => ['name' => 'eventmanagement_event_attr_value_valueInt', 'type' => 'int', 'internal' => 'valueInt'],
        'eventmanagement_event_attr_value_valueDec' => ['name' => 'eventmanagement_event_attr_value_valueDec', 'type' => 'float', 'internal' => 'valueDec'],
        'eventmanagement_event_attr_value_valueDat' => ['name' => 'eventmanagement_event_attr_value_valueDat', 'type' => 'DateTime', 'internal' => 'valueDat'],
        'eventmanagement_event_attr_value_lang'     => ['name' => 'eventmanagement_event_attr_value_lang',     'type' => 'string', 'internal' => 'language'],
        'eventmanagement_event_attr_value_country'  => ['name' => 'eventmanagement_event_attr_value_country',  'type' => 'string', 'internal' => 'country'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'eventmanagement_event_attr_value';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='eventmanagement_event_attr_value_id';
}
