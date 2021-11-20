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

use Modules\Admin\Models\AccountMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * Mapper class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class AccountRelationMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'marketing_event_accountrel_id'           => ['name' => 'marketing_event_accountrel_id',           'type' => 'int', 'internal' => 'id'],
        'marketing_event_accountrel_event'         => ['name' => 'marketing_event_accountrel_event',         'type' => 'int', 'internal' => 'event'],
        'marketing_event_accountrel_type'        => ['name' => 'marketing_event_accountrel_type',        'type' => 'int', 'internal' => 'type'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    protected static array $ownsOne = [
        'account' => [
            'mapper'     => AccountMapper::class,
            'external'   => 'marketing_event_accountrel_account',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'marketing_event_accountrel';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'marketing_event_accountrel_id';
}
