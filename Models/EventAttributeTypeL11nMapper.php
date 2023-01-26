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
use phpOMS\Localization\BaseStringL11n;

/**
 * Event mapper class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class EventAttributeTypeL11nMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'eventmanagement_event_attr_type_l11n_id'        => ['name' => 'eventmanagement_event_attr_type_l11n_id',       'type' => 'int',    'internal' => 'id'],
        'eventmanagement_event_attr_type_l11n_title'     => ['name' => 'eventmanagement_event_attr_type_l11n_title',    'type' => 'string', 'internal' => 'content', 'autocomplete' => true],
        'eventmanagement_event_attr_type_l11n_type'      => ['name' => 'eventmanagement_event_attr_type_l11n_type',      'type' => 'int',    'internal' => 'ref'],
        'eventmanagement_event_attr_type_l11n_lang'      => ['name' => 'eventmanagement_event_attr_type_l11n_lang', 'type' => 'string', 'internal' => 'language'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'eventmanagement_event_attr_type_l11n';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='eventmanagement_event_attr_type_l11n_id';

    /**
     * Model to use by the mapper.
     *
     * @var string
     * @since 1.0.0
     */
    public const MODEL = BaseStringL11n::class;
}
