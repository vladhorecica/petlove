<?php

namespace Util\Value;

class IntegerRange implements ValueObject, \JsonSerializable
{
    /** @var int|null */
    private $from;
    /** @var int|null */
    private $to;

    /**
     * @param int|null $from
     * @param int|null $to
     */
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return int|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return int|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param ValueObject|null $other
     *
     * @return bool
     */
    public function equals(ValueObject $other = null)
    {
        return $other !== null
        && $other instanceof static
        && $this->from === $other->from
        && $this->to === $other->to;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize()
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}
