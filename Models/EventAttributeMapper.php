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
final class EventAttributeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'eventmanagement_event_attr_id'     => ['name' => 'eventmanagement_event_attr_id',    'type' => 'int', 'internal' => 'id'],
        'eventmanagement_event_attr_event'  => ['name' => 'eventmanagement_event_attr_event',  'type' => 'int', 'internal' => 'event'],
        'eventmanagement_event_attr_type'   => ['name' => 'eventmanagement_event_attr_type',  'type' => 'int', 'internal' => 'type'],
        'eventmanagement_event_attr_value'  => ['name' => 'eventmanagement_event_attr_value', 'type' => 'int', 'internal' => 'value'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'            => EventAttributeTypeMapper::class,
            'external'          => 'eventmanagement_event_attr_type',
        ],
        'value' => [
            'mapper'            => EventAttributeValueMapper::class,
            'external'          => 'eventmanagement_event_attr_value',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'eventmanagement_event_attr';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'eventmanagement_event_attr_id';
}
