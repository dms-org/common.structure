<?php

namespace Dms\Common\Structure\Tests\DateTime;

use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\DateTime\TimeRange;
use Dms\Common\Structure\Tests\DateTime\DateOrTimeRangeTest;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRangeTest extends DateOrTimeRangeTest
{
    public function testNew()
    {
        $range = new TimeRange(
                $start = new TimeOfDay(06, 03, 05),
                $end = new TimeOfDay(06, 04, 05)
        );

        $this->assertSame($start, $range->getStart());
        $this->assertSame($end, $range->getEnd());
    }

    public function testStartAfterEnd()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new TimeRange(
                $start = new TimeOfDay(06, 04, 06),
                $end = new TimeOfDay(06, 04, 05)
        );
    }

    public function testContains()
    {
        $range = new TimeRange(
                $start = new TimeOfDay(06, 03, 05),
                $end = new TimeOfDay(06, 04, 05)
        );

        $this->assertSame(true, $range->contains($start));
        $this->assertSame(true, $range->contains(new TimeOfDay(06, 03, 20)));
        $this->assertSame(true, $range->contains($end));

        $this->assertSame(false, $range->contains(new TimeOfDay(06, 03, 04)));
        $this->assertSame(false, $range->contains(new TimeOfDay(06, 04, 06)));
        $this->assertSame(false, $range->contains(new TimeOfDay(03, 03, 20)));
    }

    public function testContainExclusive()
    {
        $range = new TimeRange(
                $start = new TimeOfDay(06, 03, 05),
                $end = new TimeOfDay(06, 04, 05)
        );

        $this->assertSame(false, $range->containsExclusive($start));
        $this->assertSame(true, $range->containsExclusive(new TimeOfDay(06, 03, 06)));
        $this->assertSame(true, $range->containsExclusive(new TimeOfDay(06, 03, 20)));
        $this->assertSame(false, $range->containsExclusive($end));

        $this->assertSame(false, $range->containsExclusive(new TimeOfDay(06, 03, 04)));
        $this->assertSame(false, $range->containsExclusive(new TimeOfDay(06, 04, 06)));
        $this->assertSame(false, $range->containsExclusive(new TimeOfDay(03, 03, 20)));
    }

    public function testOverlaps()
    {
        $range1 = new TimeRange(
                $start = new TimeOfDay(06, 03, 05),
                $end = new TimeOfDay(06, 04, 05)
        );

        $range2 = new TimeRange(
                $start = new TimeOfDay(06, 03, 30),
                $end = new TimeOfDay(06, 05, 30)
        );

        $range3 = new TimeRange(
                $start = new TimeOfDay(06, 05, 20),
                $end = new TimeOfDay(06, 06, 20)
        );

        $this->assertSame(true, $range1->overlaps($range1));
        $this->assertSame(true, $range1->overlaps($range2));
        $this->assertSame(true, $range2->overlaps($range3));

        $this->assertSame(true, $range2->overlaps($range1));
        $this->assertSame(true, $range3->overlaps($range2));

        $this->assertSame(false, $range1->overlaps($range3));
        $this->assertSame(false, $range3->overlaps($range1));
    }
}