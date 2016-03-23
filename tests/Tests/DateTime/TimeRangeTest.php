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

    public function testEncompasses()
    {
        $range1 = new TimeRange(
            $start = new TimeOfDay(01, 00, 00),
            $end = new TimeOfDay(12, 00, 00)
        );

        $range2 = new TimeRange(
            $start = new TimeOfDay(06, 00, 00),
            $end = new TimeOfDay(18, 00, 00)
        );

        $range3 = new TimeRange(
            $start = new TimeOfDay(03, 00, 00),
            $end = new TimeOfDay(04, 00, 00)
        );

        $this->assertSame(true, $range1->encompasses($range1));
        $this->assertSame(true, $range2->encompasses($range2));
        $this->assertSame(true, $range3->encompasses($range3));

        $this->assertSame(true, $range1->encompasses($range3));

        $this->assertSame(false, $range1->encompasses($range2));
        $this->assertSame(false, $range3->encompasses($range1));
        $this->assertSame(false, $range2->encompasses($range1));
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

    public function testOverlapsExclusive()
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
            $start = new TimeOfDay(06, 05, 30),
            $end = new TimeOfDay(06, 06, 20)
        );

        $this->assertSame(true, $range1->overlapsExclusive($range1));
        $this->assertSame(true, $range1->overlapsExclusive($range2));

        $this->assertSame(true, $range2->overlapsExclusive($range1));
        
        $this->assertSame(false, $range3->overlapsExclusive($range2));
        $this->assertSame(false, $range2->overlapsExclusive($range3));
        $this->assertSame(false, $range1->overlapsExclusive($range3));
        $this->assertSame(false, $range3->overlapsExclusive($range1));
    }
}