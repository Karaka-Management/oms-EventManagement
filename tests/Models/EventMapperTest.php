<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
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
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\EventManagement\Models\EventMapper::class)]
final class EventMapperTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testCRUD() : void
    {
        $event = new Event();

        $event->type        = EventType::SEMINAR;
        $event->name        = 'Eventname';
        $event->description = 'Event description';
        $event->createdBy   = new NullAccount(1);
        $event->start       = new \DateTime('2000-05-05');
        $event->end         = new \DateTime('2005-05-05');
        $event->unit        = 1;

        $money = new Money();
        $money->setString('1.23');

        $event->budgetCosts    = $money;
        $event->budgetEarnings = $money;
        $event->actualCosts    = $money;
        $event->actualEarnings = $money;

        $task            = new Task();
        $task->title     = 'EventTask 1';
        $task->createdBy = new NullAccount(1);

        $task2            = new Task();
        $task2->title     = 'EventTask 2';
        $task2->createdBy = new NullAccount(1);

        $event->tasks[] = $task;
        $event->tasks[] = $task2;

        $event->progress     = 11;
        $event->progressType = ProgressType::TASKS;

        $media              = new Media();
        $media->createdBy   = new NullAccount(1);
        $media->description = 'desc';
        $media->setPath('some/path');
        $media->size      = 11;
        $media->extension = 'png';
        $media->name      = 'Event Media';
        $event->files[]   = $media;

        $id = EventMapper::create()->execute($event);
        self::assertGreaterThan(0, $event->id);
        self::assertEquals($id, $event->id);

        /** @var Event $eventR */
        $eventR = EventMapper::get()->with('tasks')->with('files')->where('id', $event->id)->execute();

        self::assertEquals($event->name, $eventR->name);
        self::assertEquals($event->description, $eventR->description);
        self::assertEquals($event->start->format('Y-m-d'), $eventR->start->format('Y-m-d'));
        self::assertEquals($event->end->format('Y-m-d'), $eventR->end->format('Y-m-d'));
        self::assertEquals($event->budgetCosts->getAmount(), $eventR->budgetCosts->getAmount());
        self::assertEquals($event->budgetEarnings->getAmount(), $eventR->budgetEarnings->getAmount());
        self::assertEquals($event->actualCosts->getAmount(), $eventR->actualCosts->getAmount());
        self::assertEquals($event->actualEarnings->getAmount(), $eventR->actualEarnings->getAmount());
        self::assertEquals($event->progress, $eventR->progress);
        self::assertEquals($event->progressType, $eventR->progressType);

        $expected = $event->files;
        $actual   = $eventR->files;

        self::assertEquals(\end($expected)->name, \end($actual)->name);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNewest() : void
    {
        $newest = EventMapper::getAll()->sort('id', OrderType::DESC)->limit(1)->executeGetArray();

        self::assertCount(1, $newest);
    }
}
