<?php
/**
 * Karaka
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

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;

/**
 * Promotion class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class AccountRelation
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * Promotion
     *
     * @var int
     * @since 1.0.0
     */
    public int $event = 0;

    /**
     * Account
     *
     * @var Account
     * @since 1.0.0
     */
    public Account $account;

    /**
     * Account relation type
     *
     * @var int
     * @since 1.0.0
     */
    public int $type = AccountRelationType::VISITOR;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->account = new NullAccount();
    }

    /**
     * Get id.
     *
     * @return int Model id
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }
}
