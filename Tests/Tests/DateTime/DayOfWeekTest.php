<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Model\Object\InvalidEnumValueException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DayOfWeekTest extends CmsTestCase
{
    public function testStatic()
    {
        $this->assertSame(range(1, 7), array_values(DayOfWeek::getOptions()));
        $this->assertSame(range(1, 7), array_keys(DayOfWeek::getShortNameMap()));
        $this->assertSame(range(1, 7), array_keys(DayOfWeek::getNameMap()));

        foreach (DayOfWeek::getShortNameMap() as $name) {
            $this->assertSame(3, strlen($name));
        }
    }

    public function testGetWeekdays()
    {
        $this->assertEquals([
                DayOfWeek::monday(), DayOfWeek::tuesday(), DayOfWeek::wednesday(), DayOfWeek::thursday(), DayOfWeek::friday()
        ], DayOfWeek::weekdays());
    }

    public function testGetWeekends()
    {
        $this->assertEquals([
                DayOfWeek::saturday(), DayOfWeek::sunday()
        ], DayOfWeek::weekends());
    }

    public function testMonday()
    {
        $day = DayOfWeek::monday();

        $this->assertSame(1, $day->getValue());
        $this->assertSame(1, $day->getOrdinal());
        $this->assertSame(true, $day->isWeekDay());
        $this->assertSame(false, $day->isWeekEnd());
        $this->assertSame('Monday', $day->getName());
        $this->assertSame('Mon', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Monday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Mon'));
        $this->assertEquals($day, DayOfWeek::fromName('monDAY'));
        $this->assertEquals($day, DayOfWeek::fromShortName('mOn'));
    }

    public function testTuesday()
    {
        $day = DayOfWeek::tuesday();

        $this->assertSame(2, $day->getValue());
        $this->assertSame(2, $day->getOrdinal());
        $this->assertSame(true, $day->isWeekDay());
        $this->assertSame(false, $day->isWeekEnd());
        $this->assertSame('Tuesday', $day->getName());
        $this->assertSame('Tue', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Tuesday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Tue'));
    }

    public function testWednesday()
    {
        $day = DayOfWeek::wednesday();

        $this->assertSame(3, $day->getValue());
        $this->assertSame(3, $day->getOrdinal());
        $this->assertSame(true, $day->isWeekDay());
        $this->assertSame(false, $day->isWeekEnd());
        $this->assertSame('Wednesday', $day->getName());
        $this->assertSame('Wed', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Wednesday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Wed'));
    }

    public function testThursday()
    {
        $day = DayOfWeek::thursday();

        $this->assertSame(4, $day->getValue());
        $this->assertSame(4, $day->getOrdinal());
        $this->assertSame(true, $day->isWeekDay());
        $this->assertSame(false, $day->isWeekEnd());
        $this->assertSame('Thursday', $day->getName());
        $this->assertSame('Thu', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Thursday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Thu'));
    }

    public function testFriday()
    {
        $day = DayOfWeek::friday();

        $this->assertSame(5, $day->getValue());
        $this->assertSame(5, $day->getOrdinal());
        $this->assertSame(true, $day->isWeekDay());
        $this->assertSame(false, $day->isWeekEnd());
        $this->assertSame('Friday', $day->getName());
        $this->assertSame('Fri', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Friday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Fri'));
    }

    public function testSaturday()
    {
        $day = DayOfWeek::saturday();

        $this->assertSame(6, $day->getValue());
        $this->assertSame(6, $day->getOrdinal());
        $this->assertSame(false, $day->isWeekDay());
        $this->assertSame(true, $day->isWeekEnd());
        $this->assertSame('Saturday', $day->getName());
        $this->assertSame('Sat', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Saturday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Sat'));
    }

    public function testSunday()
    {
        $day = DayOfWeek::sunday();

        $this->assertSame(7, $day->getValue());
        $this->assertSame(7, $day->getOrdinal());
        $this->assertSame(false, $day->isWeekDay());
        $this->assertSame(true, $day->isWeekEnd());
        $this->assertSame('Sunday', $day->getName());
        $this->assertSame('Sun', $day->getShortName());
        $this->assertEquals($day, DayOfWeek::fromName('Sunday'));
        $this->assertEquals($day, DayOfWeek::fromShortName('Sun'));
    }

    public function testInvalidNames()
    {
        $this->assertThrows(function () {
            DayOfWeek::fromName('Someday');
        }, InvalidEnumValueException::class);

        $this->assertThrows(function () {
            DayOfWeek::fromShortName('Som');
        }, InvalidEnumValueException::class);
    }

    public function testInvalidType()
    {
        $this->assertThrows(function () {
            new DayOfWeek('Monday'); // should be: new DateOfWeek(DateOfWeek::MONDAY)
        }, InvalidEnumValueException::class);
    }
}