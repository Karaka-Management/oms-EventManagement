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

use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventType;
use Modules\EventManagement\Models\ProgressType;
use Modules\Media\Models\Media;
use Modules\Tasks\Models\Task;
use phpOMS\Localization\Money;

/**
 * @internal
 */
final class EventTest extends \PHPUnit\Framework\TestCase
{
    private Event $event;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->event = new Event();
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->event->getId());
        self::assertEquals(EventType::DEFAULT, $this->event->getType());
        self::assertInstanceOf('\Modules\Calendar\Models\Calendar', $this->event->calendar);
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $this->event->start->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->modify('+1 month')->format('Y-m-d'), $this->event->end->format('Y-m-d'));
        self::assertEquals(0, $this->event->budgetCosts->getInt());
        self::assertEquals(0, $this->event->actualCosts->getInt());
        self::assertEquals(0, $this->event->budgetEarnings->getInt());
        self::assertEquals(0, $this->event->actualEarnings->getInt());
        self::assertFalse($this->event->removeTask(2));
        self::assertEmpty($this->event->getTasks());
        self::assertEmpty($this->event->getMedia());
        self::assertInstanceOf('\Modules\Tasks\Models\NullTask', $this->event->getTask(1));
        self::assertEquals(0, $this->event->progress);
        self::assertEquals(ProgressType::MANUAL, $this->event->getProgressType());
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testTypeInputOutput() : void
    {
        $this->event->setType(EventType::SEMINAR);
        self::assertEquals(EventType::SEMINAR, $this->event->getType());
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testInvalidTypeInputOutput() : void
    {
        $this->expectException(\phpOMS\Stdlib\Base\Exception\InvalidEnumValue::class);
        $this->event->setType(999);
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testMediaInputOutput() : void
    {
        $this->event->addMedia(new Media());
        self::assertCount(1, $this->event->getMedia());
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testTaskInputOutput() : void
    {
        $task        = new Task();
        $task->title = 'A';

        $this->event->addTask($task);
        self::assertEquals('A', $this->event->getTask(0)->title);

        self::assertTrue($this->event->removeTask(0));
        self::assertEquals(0, $this->event->countTasks());

        $this->event->addTask($task);
        self::assertCount(1, $this->event->getTasks());
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testProgressInputOutput() : void
    {
        $this->event->progress = 10;
        self::assertEquals(10, $this->event->progress);
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testProgressTypeInputOutput() : void
    {
        $this->event->setProgressType(ProgressType::TASKS);
        self::assertEquals(ProgressType::TASKS, $this->event->getProgressType());
    }

    /**
     * @covers Modules\EventManagement\Models\Event
     * @group module
     */
    public function testSerialize() : void
    {
        $this->event->name        = 'Name';
        $this->event->description = 'Description';
        $this->event->start       = new \DateTime();
        $this->event->end         = new \DateTime();
        $this->event->setType(EventType::SEMINAR);
        $this->event->progress = 10;
        $this->event->setProgressType(ProgressType::TASKS);

        $serialized = $this->event->jsonSerialize();
        unset($serialized['calendar']);
        unset($serialized['createdAt']);

        self::assertEquals(
            [
                'id'           => 0,
                'type'         => EventType::SEMINAR,
                'start'        => $this->event->start,
                'end'          => $this->event->end,
                'name'         => 'Name',
                'description'  => 'Description',
                'budgetCosts'        => new Money(),
                'budgetEarnings'       => new Money(),
                'actualCosts'     => new Money(),
                'actualEarnings'     => new Money(),
                'tasks'        => [],
                'media'        => [],
                'progress'     => 10,
                'progressType' => ProgressType::TASKS,
            ],
            $serialized
        );
    }
}
