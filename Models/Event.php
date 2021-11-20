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

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;
use Modules\Calendar\Models\Calendar;
use Modules\Tasks\Models\NullTask;
use Modules\Tasks\Models\Task;
use phpOMS\Localization\Money;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

/**
 * Event class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Event
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Type.
     *
     * @var int
     * @since 1.0.0
     */
    private int $type = EventType::DEFAULT;

    /**
     * Event start.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    public \DateTime $start;

    /**
     * Event end.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    public \DateTime $end;

    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    public string $description = '';

    /**
     * Calendar.
     *
     * @var Calendar
     * @since 1.0.0
     */
    public Calendar $calendar;

    /**
     * Costs.
     *
     * @var Money
     * @since 1.0.0
     */
    public Money $budgetCosts;

    /**
     * Earnings.
     *
     * @var Money
     * @since 1.0.0
     */
    public Money $budgetEarnings;

    /**
     * Costs.
     *
     * @var Money
     * @since 1.0.0
     */
    public Money $actualCosts;

    /**
     * Earnings.
     *
     * @var Money
     * @since 1.0.0
     */
    public Money $actualEarnings;

    /**
     * Tasks.
     *
     * @var Task[]
     * @since 1.0.0
     */
    private array $tasks = [];

    /**
     * Media.
     *
     * @var \Modules\Media\Models\Media[]
     * @since 1.0.0
     */
    private array $media = [];

    /**
     * Progress (0-100).
     *
     * @var int
     * @since 1.0.0
     */
    public int $progress = 0;

    /**
     * Progress type.
     *
     * @var int
     * @since 1.0.0
     */
    private int $progressType = ProgressType::MANUAL;

    /**
     * Created.
     *
     * @var \DateTimeImmutable
     * @since 1.0.0
     */
    public \DateTimeImmutable $createdAt;

    /**
     * Creator.
     *
     * @var Account
     * @since 1.0.0
     */
    public Account $createdBy;

    /**
     * Account relations
     *
     * @var AccountRelation[]
     * @since 1.0.0
     */
    private array $accountRelations = [];

    /**
     * Attributes.
     *
     * @var int[]|EventAttribute[]
     * @since 1.0.0
     */
    private array $attributes = [];

    /**
     * Constructor.
     *
     * @param string $name Event name/title
     *
     * @since 1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->start     = new \DateTime('now');
        $this->end       = (new \DateTime('now'))->modify('+1 month');
        $this->calendar  = new Calendar();
        $this->budgetCosts     = new Money();
        $this->budgetEarnings    = new Money();
        $this->actualCosts  = new Money();
        $this->actualEarnings  = new Money();
        $this->createdAt = new \DateTimeImmutable('now');
        $this->createdBy = new NullAccount();

        $this->name = $name;
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

    /**
     * Get media files.
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getMedia() : array
    {
        return $this->media;
    }

    /**
     * Add media file.
     *
     * @param mixed $media Media
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addMedia($media) : void
    {
        $this->media[] = $media;
    }

    /**
     * Get progress type.
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getProgressType() : int
    {
        return $this->progressType;
    }

    /**
     * Set progress type.
     *
     * @param int $type Progress type
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setProgressType(int $type) : void
    {
        $this->progressType = $type;
    }

    /**
     * Add task.
     *
     * @param Task $task Task
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addTask(Task $task) : void
    {
        $this->tasks[] = $task;
    }

    /**
     * Remove task
     *
     * @param int $id id to remove
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public function removeTask(int $id) : bool
    {
        if (isset($this->tasks[$id])) {
            unset($this->tasks[$id]);

            return true;
        }

        return false;
    }

    /**
     * Get task by id.
     *
     * @param int $id Task id
     *
     * @return Task
     *
     * @since 1.0.0
     */
    public function getTask(int $id) : Task
    {
        return $this->tasks[$id] ?? new NullTask();
    }

    /**
     * Get tasks.
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getTasks() : array
    {
        return $this->tasks;
    }

    /**
     * Count tasks.
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function countTasks() : int
    {
        return \count($this->tasks);
    }

    /**
     * Set type
     *
     * @param int $type Type
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setType(int $type) : void
    {
        if (!EventType::isValidValue($type)) {
            throw new InvalidEnumValue($type);
        }

        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * Add account relation
     *
     * @param AccountRelation $accRel Account relation
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addAccount(AccountRelation $accRel) : void
    {
        $this->accountRelations[] = $accRel;
    }

     /**
     * Add attribute to item
     *
     * @param EventAttribute $attribute Note
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addAttribute(EventAttribute $attribute) : void
    {
        $this->attributes[] = $attribute;
    }

    /**
     * Get attributes
     *
     * @return int[]|EventAttribute[]
     *
     * @since 1.0.0
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'           => $this->id,
            'type'         => $this->type,
            'start'        => $this->start,
            'end'          => $this->end,
            'name'         => $this->name,
            'description'  => $this->description,
            'calendar'     => $this->calendar,
            'budgetCosts'        => $this->budgetCosts,
            'budgetEarnings'        => $this->budgetEarnings,
            'actualCosts'        => $this->actualCosts,
            'actualEarnings'        => $this->actualEarnings,
            'tasks'        => $this->tasks,
            'media'        => $this->media,
            'progress'     => $this->progress,
            'progressType' => $this->progressType,
            'createdAt'    => $this->createdAt,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
