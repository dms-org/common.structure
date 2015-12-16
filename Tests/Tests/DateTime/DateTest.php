<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime;

use Iddigital\Cms\Common\Structure\DateTime\Date;
use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTest extends DateOrTimeObjectTest
{
    public function testNew()
    {
        $date = new Date(2015, 03, 05);

        $this->assertInstanceOf(\DateTimeImmutable::class, $date->getNativeDateTime());
        $this->assertSame('2015-03-05 00:00:00', $date->getNativeDateTime()->format('Y-m-d H:i:s'));
        $this->assertSame('UTC', $date->getNativeDateTime()->getTimezone()->getName());
        $this->assertSame(2015, $date->getYear());
        $this->assertSame(3, $date->getMonth());
        $this->assertSame(5, $date->getDay());
        $this->assertEquals(DayOfWeek::thursday(), $date->getDayOfTheWeek());
        $this->assertSame(true, $date->equals($date));
        $this->assertSame(true, $date->equals(clone $date));
    }

    public function testFormatting()
    {
        $date = new Date(2015, 03, 05);

        $this->assertSame('2015-03-05', $date->format('Y-m-d'));
        $this->assertSame('His', $date->format('His'));
        $this->assertSame('Y-m-05', $date->format('\Y-\m-d'));
        $this->assertSame('2015-03-05 H:i:s', $date->format('Y-m-d H:i:s'));
        $this->assertSame('2015-m-05 H:i:s', $date->format('Y-\m-d \H\:i:s'));
        $this->assertSame('2015\\2015', $date->format('Y\\\\Y'));
        $this->assertSame('Thursday', $date->format('l'));
        $this->assertSame((string)$date->getTimestamp(), $date->format('U'));
    }

    public function testFromNativeObject()
    {
        $date = Date::fromNative(new \DateTime('2001-05-1'));
        $this->assertSame(2001, $date->getYear());
        $this->assertSame(5, $date->getMonth());
        $this->assertSame(1, $date->getDay());
    }

    public function testFromFormat()
    {
        $date = Date::fromFormat('d/m/Y', '21/8/2001');

        $this->assertSame(2001, $date->getYear());
        $this->assertSame(8, $date->getMonth());
        $this->assertSame(21, $date->getDay());
    }

    public function testAddingAndSubtracting()
    {
        $date = new Date(2000, 1, 1);

        $otherTime = $date->addYears(10)->subMonths(3)->addDays(20);

        $this->assertNotSame($date, $otherTime);
        $this->assertSame('2000-01-01', $date->format('Y-m-d'));
        $this->assertSame('2009-10-21', $otherTime->format('Y-m-d'));
    }

    public function testComparisons()
    {
        $date = new Date(2000, 1, 1);

        $this->assertFalse($date->comesBefore($date));
        $this->assertFalse($date->comesBefore($date->subDays(1)));
        $this->assertTrue($date->comesBefore($date->addDays(1)));

        $this->assertTrue($date->comesBeforeOrEqual($date));
        $this->assertFalse($date->comesBeforeOrEqual($date->subDays(1)));
        $this->assertTrue($date->comesBeforeOrEqual($date->addDays(1)));

        $this->assertFalse($date->comesAfter($date));
        $this->assertFalse($date->comesAfter($date->addDays(1)));
        $this->assertTrue($date->comesAfter($date->subDays(1)));

        $this->assertTrue($date->comesAfterOrEqual($date));
        $this->assertFalse($date->comesAfterOrEqual($date->addDays(1)));
        $this->assertTrue($date->comesAfterOrEqual($date->subDays(1)));
    }
}