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
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

use Modules\Admin\Models\AccountMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Tasks\Models\TaskMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Mapper class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
final class EventMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'eventmanagement_event_id'                  => ['name' => 'eventmanagement_event_id',            'type' => 'int',          'internal' => 'id'],
        'eventmanagement_event_name'                => ['name' => 'eventmanagement_event_name',          'type' => 'string',       'internal' => 'name'],
        'eventmanagement_event_description'         => ['name' => 'eventmanagement_event_description',   'type' => 'string',       'internal' => 'description'],
        'eventmanagement_event_type'                => ['name' => 'eventmanagement_event_type',          'type' => 'int',          'internal' => 'type'],
        'eventmanagement_event_calendar'            => ['name' => 'eventmanagement_event_calendar',      'type' => 'int',          'internal' => 'calendar'],
        'eventmanagement_event_start'               => ['name' => 'eventmanagement_event_start',         'type' => 'DateTime',     'internal' => 'start'],
        'eventmanagement_event_end'                 => ['name' => 'eventmanagement_event_end',           'type' => 'DateTime',     'internal' => 'end'],
        'eventmanagement_event_progress'            => ['name' => 'eventmanagement_event_progress',      'type' => 'int',          'internal' => 'progress'],
        'eventmanagement_event_progress_type'       => ['name' => 'eventmanagement_event_progress_type', 'type' => 'int',          'internal' => 'progressType'],
        'eventmanagement_event_budgetcosts'         => ['name' => 'eventmanagement_event_budgetcosts',         'type' => 'Serializable', 'internal' => 'budgetCosts'],
        'eventmanagement_event_budgetearnings'      => ['name' => 'eventmanagement_event_budgetearnings',      'type' => 'Serializable', 'internal' => 'budgetEarnings'],
        'eventmanagement_event_actualcosts'         => ['name' => 'eventmanagement_event_actualcosts',         'type' => 'Serializable', 'internal' => 'actualCosts'],
        'eventmanagement_event_actualearnings'      => ['name' => 'eventmanagement_event_actualearnings',      'type' => 'Serializable', 'internal' => 'actualEarnings'],
        'eventmanagement_event_created_by'          => ['name' => 'eventmanagement_event_created_by',    'type' => 'int',          'internal' => 'createdBy', 'readonly' => true],
        'eventmanagement_event_created_at'          => ['name' => 'eventmanagement_event_created_at',    'type' => 'DateTimeImmutable', 'internal' => 'createdAt', 'readonly' => true],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'tasks' => [
            'mapper'   => TaskMapper::class,
            'table'    => 'eventmanagement_task_relation',
            'external' => 'eventmanagement_task_relation_src',
            'self'     => 'eventmanagement_task_relation_dst',
        ],
        'media' => [
            'mapper'   => MediaMapper::class,
            'table'    => 'eventmanagement_event_media',
            'external' => 'eventmanagement_event_media_dst',
            'self'     => 'eventmanagement_event_media_src',
        ],
        'attributes' => [
            'mapper'      => EventAttributeMapper::class,
            'table'       => 'eventmanagement_event_attr',
            'self'        => 'eventmanagement_event_attr_event',
            'conditional' => true,
            'external'    => null,
        ],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'calendar' => [
            'mapper'     => \Modules\Calendar\Models\CalendarMapper::class,
            'external'   => 'eventmanagement_event_calendar',
        ],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'createdBy' => [
            'mapper'     => AccountMapper::class,
            'external'   => 'eventmanagement_event_created_by',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'eventmanagement_event';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    public const CREATED_AT = 'eventmanagement_event_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='eventmanagement_event_id';
}
