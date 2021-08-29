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
    private int $id = 0;

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
    private Calendar $calendar;

    /**
     * Costs.
     *
     * @var Money
     * @since 1.0.0
     */
    private Money $costs;

    /**
     * Budget.
     *
     * @var Money
     * @since 1.0.0
     */
    private Money $budget;

    /**
     * Earnings.
     *
     * @var Money
     * @since 1.0.0
     */
    private Money $earnings;

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
     * @var Media[]
     * @since 1.0.0
     */
    private array $media = [];

    /**
     * Progress (0-100).
     *
     * @var int
     * @since 1.0.0
     */
    private int $progress = 0;

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
        $this->costs     = new Money();
        $this->budget    = new Money();
        $this->earnings  = new Money();
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
     * Get start date.
     *
     * @return \DateTime
     *
     * @since 1.0.0
     */
    public function getStart() : \DateTime
    {
        return $this->start;
    }

    /**
     * Set start date.
     *
     * @param \DateTime $start Start date
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setStart(\DateTime $start) : void
    {
        $this->start = $start;
    }

    /**
     * Set end.
     *
     * @param \DateTime $end End date
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setEnd(\DateTime $end) : void
    {
        $this->end = $end;
    }

    /**
     * Get end.
     *
     * @return \DateTime
     *
     * @since 1.0.0
     */
    public function getEnd() : \DateTime
    {
        return $this->end;
    }

    /**
     * Get progress.
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getProgress() : int
    {
        return $this->progress;
    }

    /**
     * Set progress.
     *
     * @param int $progress Progress
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setProgress(int $progress) : void
    {
        $this->progress = $progress;
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
     * Get calendar.
     *
     * @return Calendar
     *
     * @since 1.0.0
     */
    public function getCalendar() : Calendar
    {
        return $this->calendar;
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
        if ($task->getId() !== 0) {
            $this->tasks[$task->getId()] = $task;
        } else {
            $this->tasks[] = $task;
        }
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
        return $this->tasks[$id] ?? new Task();
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
     * Get costs.
     *
     * @return Money
     *
     * @since 1.0.0
     */
    public function getCosts() : Money
    {
        return $this->costs;
    }

    /**
     * Get budget.
     *
     * @return Money
     *
     * @since 1.0.0
     */
    public function getBudget() : Money
    {
        return $this->budget;
    }

    /**
     * Get earnings.
     *
     * @return Money
     *
     * @since 1.0.0
     */
    public function getEarnings() : Money
    {
        return $this->earnings;
    }

    /**
     * Set costs.
     *
     * @param Money $costs Costs
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setCosts(Money $costs) : void
    {
        $this->costs = $costs;
    }

    /**
     * Set budget.
     *
     * @param Money $budget Budget
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setBudget(Money $budget) : void
    {
        $this->budget = $budget;
    }

    /**
     * Set earnings.
     *
     * @param Money $earnings Earnings
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setEarnings(Money $earnings) : void
    {
        $this->earnings = $earnings;
    }
}
