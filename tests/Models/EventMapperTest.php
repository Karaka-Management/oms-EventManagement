<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\EventManagement\tests\Models;

use Modules\Admin\Models\NullAccount;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventMapper;
use Modules\EventManagement\Models\EventType;
use Modules\EventManagement\Models\ProgressType;
use Modules\Media\Models\Media;
use Modules\Tasks\Models\Task;
use phpOMS\DataStorage\Database\Query\OrderType;
use phpOMS\Localization\Money;

/**
 * @internal
 */
final class EventMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\EventManagement\Models\EventMapper
     * @group module
     */
    public function testCRUD() : void
    {
        $event = new Event();

        $event->setType(EventType::SEMINAR);
        $event->name        = 'Eventname';
        $event->description = 'Event description';
        $event->createdBy   = new NullAccount(1);
        $event->start       = new \DateTime('2000-05-05');
        $event->end         = new \DateTime('2005-05-05');

        $money = new Money();
        $money->setString('1.23');

        $event->budgetCosts    = $money;
        $event->budgetEarnings   = $money;
        $event->actualCosts = $money;
        $event->actualEarnings = $money;

        $task        = new Task();
        $task->title = 'EventTask 1';
        $task->setCreatedBy(new NullAccount(1));

        $task2        = new Task();
        $task2->title = 'EventTask 2';
        $task2->setCreatedBy(new NullAccount(1));

        $event->addTask($task);
        $event->addTask($task2);

        $event->progress = 11;
        $event->setProgressType(ProgressType::TASKS);

        $media              = new Media();
        $media->createdBy   = new NullAccount(1);
        $media->description = 'desc';
        $media->setPath('some/path');
        $media->size      = 11;
        $media->extension = 'png';
        $media->name      = 'Event Media';
        $event->addMedia($media);

        $id = EventMapper::create()->execute($event);
        self::assertGreaterThan(0, $event->getId());
        self::assertEquals($id, $event->getId());

        $eventR = EventMapper::get()->with('tasks')->with('media')->where('id', $event->getId())->execute();

        self::assertEquals($event->name, $eventR->name);
        self::assertEquals($event->description, $eventR->description);
        self::assertEquals($event->countTasks(), $eventR->countTasks());
        self::assertEquals($event->start->format('Y-m-d'), $eventR->start->format('Y-m-d'));
        self::assertEquals($event->end->format('Y-m-d'), $eventR->end->format('Y-m-d'));
        self::assertEquals($event->budgetCosts->getAmount(), $eventR->budgetCosts->getAmount());
        self::assertEquals($event->budgetEarnings->getAmount(), $eventR->budgetEarnings->getAmount());
        self::assertEquals($event->actualCosts->getAmount(), $eventR->actualCosts->getAmount());
        self::assertEquals($event->actualEarnings->getAmount(), $eventR->actualEarnings->getAmount());
        self::assertEquals($event->progress, $eventR->progress);
        self::assertEquals($event->getProgressType(), $eventR->getProgressType());

        $expected = $event->getMedia();
        $actual   = $eventR->getMedia();

        self::assertEquals(\end($expected)->name, \end($actual)->name);
    }

    /**
     * @covers Modules\EventManagement\Models\EventMapper
     * @group module
     */
    public function testNewest() : void
    {
        $newest = EventMapper::getAll()->sort('id', OrderType::DESC)->limit(1)->execute();

        self::assertCount(1, $newest);
    }
}
