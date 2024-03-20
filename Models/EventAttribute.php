<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EventManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

/**
 * Event class.
 *
 * @package Modules\EventManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class EventAttribute implements \JsonSerializable
{
    /**
     * Id.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * Event this attribute belongs to
     *
     * @var int
     * @since 1.0.0
     */
    public int $event = 0;

    /**
     * Attribute type the attribute belongs to
     *
     * @var EventAttributeType
     * @since 1.0.0
     */
    public EventAttributeType $type;

    /**
     * Attribute value the attribute belongs to
     *
     * @var EventAttributeValue
     * @since 1.0.0
     */
    public EventAttributeValue $value;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->type  = new NullEventAttributeType();
        $this->value = new NullEventAttributeValue();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'    => $this->id,
            'event' => $this->event,
            'type'  => $this->type,
            'value' => $this->value,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
