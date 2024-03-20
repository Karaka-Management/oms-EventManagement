<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\tests\Models;

use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventType;
use Modules\EventManagement\Models\ProgressType;
use phpOMS\Stdlib\Base\FloatInt;

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
     * @covers \Modules\EventManagement\Models\Event
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->event->id);
        self::assertEquals(EventType::DEFAULT, $this->event->type);
        self::assertInstanceOf('\Modules\Calendar\Models\Calendar', $this->event->calendar);
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $this->event->start->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->modify('+1 month')->format('Y-m-d'), $this->event->end->format('Y-m-d'));
        self::assertEquals(0, $this->event->budgetCosts->getInt());
        self::assertEquals(0, $this->event->actualCosts->getInt());
        self::assertEquals(0, $this->event->budgetEarnings->getInt());
        self::assertEquals(0, $this->event->actualEarnings->getInt());
        self::assertEmpty($this->event->tasks);
        self::assertEmpty($this->event->files);
        self::assertEquals(0, $this->event->progress);
        self::assertEquals(ProgressType::MANUAL, $this->event->progressType);
    }

    /**
     * @covers \Modules\EventManagement\Models\Event
     * @group module
     */
    public function testProgressInputOutput() : void
    {
        $this->event->progress = 10;
        self::assertEquals(10, $this->event->progress);
    }

    /**
     * @covers \Modules\EventManagement\Models\Event
     * @group module
     */
    public function testSerialize() : void
    {
        $this->event->name         = 'Name';
        $this->event->description  = 'Description';
        $this->event->start        = new \DateTime();
        $this->event->end          = new \DateTime();
        $this->event->type         = EventType::SEMINAR;
        $this->event->progress     = 10;
        $this->event->progressType = ProgressType::TASKS;

        $serialized = $this->event->jsonSerialize();
        unset($serialized['calendar']);
        unset($serialized['createdAt']);

        self::assertEquals(
            [
                'id'             => 0,
                'type'           => EventType::SEMINAR,
                'start'          => $this->event->start,
                'end'            => $this->event->end,
                'name'           => 'Name',
                'description'    => 'Description',
                'budgetCosts'    => new FloatInt(),
                'budgetEarnings' => new FloatInt(),
                'actualCosts'    => new FloatInt(),
                'actualEarnings' => new FloatInt(),
                'tasks'          => [],
                'files'          => [],
                'progress'       => 10,
                'progressType'   => ProgressType::TASKS,
            ],
            $serialized
        );
    }
}
