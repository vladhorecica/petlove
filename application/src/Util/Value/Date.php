<?php

namespace Util\Value;

class Date implements ValueObject, \JsonSerializable
{
    /** @var int */
    private $year;
    /** @var int */
    private $month;
    /** @var int */
    private $day;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct($year, $month, $day)
    {
        $this->year = (int) $year;
        $this->month = (int) $month;
        $this->day = (int) $day;
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return self
     */
    public static function fromDateTime(\DateTimeInterface $dateTime)
    {
        return new self(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d')
        );
    }

    /**
     * @return Date
     */
    public static function today()
    {
        return self::fromDateTime(new \DateTimeImmutable());
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return Date
     */
    public function add(\DateInterval $dateInterval)
    {
        $dateTime = $this->getDateTime()->add($dateInterval);

        return self::fromDateTime($dateTime);
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return Date
     */
    public function sub(\DateInterval $dateInterval)
    {
        $dateTime = $this->getDateTime()->sub($dateInterval);

        return self::fromDateTime($dateTime);
    }

    /**
     * @param ValueObject $other
     *
     * @return bool
     */
    public function lte(ValueObject $other)
    {
        return $other instanceof self && $this <= $other;
    }

    /**
     * @param ValueObject $other
     *
     * @return bool
     */
    public function lt(ValueObject $other)
    {
        return $other instanceof self && $this < $other;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->jsonSerialize();
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return "{$this->year}-{$this->month}-{$this->day}";
    }

    /**
     * @param ValueObject|null $other
     *
     * @return bool
     */
    public function equals(ValueObject $other = null)
    {
        return $other instanceof self
            && $this->year === $other->year
            && $this->month === $other->month
            && $this->day === $other->day
        ;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTime()
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d', $this);
    }
}
