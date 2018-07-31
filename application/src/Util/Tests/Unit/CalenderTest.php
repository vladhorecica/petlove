<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit;

use Util\Util\Calendar;

class CalenderTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testDiffInMonths()
    {
        $date2 = new \DateTimeImmutable('01.11.2013');
        $date1 = new \DateTimeImmutable('30.11.2013');

        $this->assertSame(0, Calendar::diffInMonths($date1, $date2));

        $date1 = new \DateTimeImmutable('01.01.2013');
        $date2 = new \DateTimeImmutable('31.12.2013');

        $this->assertSame(11, Calendar::diffInMonths($date1, $date2));

        $date1 = new \DateTimeImmutable('31.01.2011');
        $date2 = new \DateTimeImmutable('28.02.2011');

        $this->assertSame(0, Calendar::diffInMonths($date1, $date2));

        $date1 = new \DateTimeImmutable('25.12.2011');
        $date2 = new \DateTimeImmutable('24.01.2012');

        $this->assertSame(0, Calendar::diffInMonths($date1, $date2));

        $date1 = new \DateTimeImmutable('25.12.2011');
        $date2 = new \DateTimeImmutable('25.01.2012');

        $this->assertSame(1, Calendar::diffInMonths($date1, $date2));
    }

    /**
     */
    public function testDiffInDays()
    {
        $date2 = new \DateTimeImmutable('01.11.2013');
        $date1 = new \DateTimeImmutable('30.11.2013');

        $this->assertSame(29, Calendar::diffInDays($date1, $date2));

        $date1 = new \DateTimeImmutable('31.01.2013');
        $date2 = new \DateTimeImmutable('01.01.2013');

        $this->assertSame(30, Calendar::diffInDays($date1, $date2));

        $date1 = new \DateTimeImmutable('31.01.2013');
        $date2 = $date1;

        $this->assertSame(0, Calendar::diffInDays($date1, $date2));

        $date1 = new \DateTimeImmutable('01.01.2013');
        $date2 = new \DateTimeImmutable('01.02.2013');

        $this->assertSame(31, Calendar::diffInDays($date1, $date2));
    }
}
