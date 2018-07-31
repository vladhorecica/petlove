<?php

namespace Util\Tests\Unit;

use Util\Value\Date;

class DateTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testLte()
    {
        $now = new \DateTimeImmutable();

        $date2 = Date::fromDateTime($now);
        $date1 = Date::fromDateTime($now);

        $this->assertTrue($date1->lte($date2));

        $date1 = Date::fromDateTime($now);
        $date2 = Date::fromDateTime($now->add(new \DateInterval('P1D')));

        $this->assertTrue($date1->lte($date2));

        $date1 = Date::fromDateTime($now);
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P1D')));

        $this->assertFalse($date1->lte($date2));

        $date1 = Date::fromDateTime($now->sub(new \DateInterval('P1W')));
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P6D')));

        $this->assertTrue($date1->lte($date2));

        $date1 = Date::fromDateTime($now->sub(new \DateInterval('P1W')));
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P7D')));

        $this->assertTrue($date1->lte($date2));

        $date1 = Date::fromDateTime($now->sub(new \DateInterval('P1W')));
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P8D')));

        $this->assertFalse($date1->lte($date2));
    }

    /**
     */
    public function testLt()
    {
        $now = new \DateTimeImmutable();

        $date2 = Date::fromDateTime($now);
        $date1 = Date::fromDateTime($now);

        $this->assertFalse($date1->lt($date2));

        $date1 = Date::fromDateTime($now);
        $date2 = Date::fromDateTime($now->add(new \DateInterval('P1D')));

        $this->assertTrue($date1->lt($date2));

        $date1 = Date::fromDateTime($now);
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P1D')));

        $this->assertFalse($date1->lt($date2));

        $date1 = Date::fromDateTime($now->sub(new \DateInterval('P1W')));
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P6D')));

        $this->assertTrue($date1->lt($date2));

        $date1 = Date::fromDateTime($now->sub(new \DateInterval('P1W')));
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P7D')));

        $this->assertFalse($date1->lt($date2));

        $date1 = Date::fromDateTime($now->sub(new \DateInterval('P1W')));
        $date2 = Date::fromDateTime($now->sub(new \DateInterval('P8D')));

        $this->assertFalse($date1->lt($date2));
    }

    /**
     */
    public function testAdd()
    {
        $date = new Date(2016, 1, 1);
        $newDate = $date->add(new \DateInterval('P1D'));
        $this->assertTrue($newDate->equals(new Date(2016, 1, 2)));

        $newDate = $date->add(new \DateInterval('P1M'));
        $this->assertTrue($newDate->equals(new Date(2016, 2, 1)));

        $newDate = $date->add(new \DateInterval('P1Y'));
        $this->assertTrue($newDate->equals(new Date(2017, 1, 1)));

        $newDate = $date->add(new \DateInterval('P1D'))->add(new \DateInterval('P1M'));
        $this->assertTrue($newDate->equals(new Date(2016, 2, 2)));
    }
}
