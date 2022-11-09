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
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Mapper class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
final class AccountRelationMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'eventmanagement_event_accountrel_id'            => ['name' => 'eventmanagement_event_accountrel_id',           'type' => 'int', 'internal' => 'id'],
        'eventmanagement_event_accountrel_event'         => ['name' => 'eventmanagement_event_accountrel_event',         'type' => 'int', 'internal' => 'event'],
        'eventmanagement_event_accountrel_type'          => ['name' => 'eventmanagement_event_accountrel_type',        'type' => 'int', 'internal' => 'type'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'account' => [
            'mapper'     => AccountMapper::class,
            'external'   => 'eventmanagement_event_accountrel_account',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'eventmanagement_event_accountrel';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='eventmanagement_event_accountrel_id';
}
