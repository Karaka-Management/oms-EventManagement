<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\EventManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * Event mapper class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class EventAttributeTypeMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'eventmanagement_event_attr_type_id'       => ['name' => 'eventmanagement_event_attr_type_id',     'type' => 'int',    'internal' => 'id'],
        'eventmanagement_event_attr_type_name'     => ['name' => 'eventmanagement_event_attr_type_name',   'type' => 'string', 'internal' => 'name', 'autocomplete' => true],
        'eventmanagement_event_attr_type_fields'   => ['name' => 'eventmanagement_event_attr_type_fields', 'type' => 'int',    'internal' => 'fields'],
        'eventmanagement_event_attr_type_custom'   => ['name' => 'eventmanagement_event_attr_type_custom', 'type' => 'bool', 'internal' => 'custom'],
        'eventmanagement_event_attr_type_pattern'  => ['name' => 'eventmanagement_event_attr_type_pattern', 'type' => 'string', 'internal' => 'validationPattern'],
        'eventmanagement_event_attr_type_required' => ['name' => 'eventmanagement_event_attr_type_required', 'type' => 'bool', 'internal' => 'isRequired'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    protected static array $hasMany = [
        'l11n' => [
            'mapper'            => EventAttributeTypeL11nMapper::class,
            'table'             => 'eventmanagement_event_attr_type_l11n',
            'self'              => 'eventmanagement_event_attr_type_l11n_type',
            'column'            => 'title',
            'conditional'       => true,
            'external'          => null,
        ],
        'defaults' => [
            'mapper'            => EventAttributeValueMapper::class,
            'table'             => 'eventmanagement_event_attr_default',
            'self'              => 'eventmanagement_event_attr_default_type',
            'external'          => 'eventmanagement_event_attr_default_value',
            'conditional'       => false,
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'eventmanagement_event_attr_type';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'eventmanagement_event_attr_type_id';
}
