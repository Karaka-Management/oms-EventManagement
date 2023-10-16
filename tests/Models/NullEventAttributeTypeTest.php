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

use Modules\EventManagement\Models\NullEventAttributeType;

/**
 * @internal
 */
final class NullEventAttributeTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\EventManagement\Models\NullEventAttributeType
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\EventManagement\Models\EventAttributeType', new NullEventAttributeType());
    }

    /**
     * @covers Modules\EventManagement\Models\NullEventAttributeType
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullEventAttributeType(2);
        self::assertEquals(2, $null->getId());
    }

    /**
     * @covers Modules\EventManagement\Models\NullEventAttributeType
     * @group framework
     */
    public function testJsonSerialize() : void
    {
        $null = new NullEventAttributeType(2);
        self::assertEquals(['id' => 2], $null);
    }
}
