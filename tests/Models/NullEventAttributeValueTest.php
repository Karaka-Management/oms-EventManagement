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

use Modules\EventManagement\Models\NullEventAttributeValue;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\EventManagement\Models\NullEventAttributeValue::class)]
final class NullEventAttributeValueTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\EventManagement\Models\EventAttributeValue', new NullEventAttributeValue());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testId() : void
    {
        $null = new NullEventAttributeValue(2);
        self::assertEquals(2, $null->id);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testJsonSerialize() : void
    {
        $null = new NullEventAttributeValue(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
