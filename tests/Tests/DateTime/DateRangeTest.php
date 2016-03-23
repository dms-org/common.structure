<?php

namespace Dms\Common\Structure\Tests\DateTime;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateRange;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeTest extends DateOrTimeRangeTest
{
    public function testNew()
    {
        $range = new DateRange(
                $start = new Date(2015, 03, 05),
                $end = new Date(2015, 04, 05)
        );

        $this->assertSame($start, $range->getStart());
        $this->assertSame($end, $range->getEnd());
    }

    public function testStartAfterEnd()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new DateRange(
                $start = new Date(2015, 04, 06),
                $end = new Date(2015, 04, 05)
        );
    }

    public function testContains()
    {
        $range = new DateRange(
                $start = new Date(2015, 03, 05),
                $end = new Date(2015, 04, 05)
        );

        $this->assertSame(true, $range->contains($start));
        $this->assertSame(true, $range->contains(new Date(2015, 03, 20)));
        $this->assertSame(true, $range->contains($end));

        $this->assertSame(false, $range->contains(new Date(2015, 03, 04)));
        $this->assertSame(false, $range->contains(new Date(2015, 04, 06)));
        $this->assertSame(false, $range->contains(new Date(2012, 03, 20)));
    }

    public function testContainExclusive()
    {
        $range = new DateRange(
                $start = new Date(2015, 03, 05),
                $end = new Date(2015, 04, 05)
        );

        $this->assertSame(false, $range->containsExclusive($start));
        $this->assertSame(true, $range->containsExclusive(new Date(2015, 03, 06)));
        $this->assertSame(true, $range->containsExclusive(new Date(2015, 03, 20)));
        $this->assertSame(false, $range->containsExclusive($end));

        $this->assertSame(false, $range->containsExclusive(new Date(2015, 03, 04)));
        $this->assertSame(false, $range->containsExclusive(new Date(2015, 04, 06)));
        $this->assertSame(false, $range->containsExclusive(new Date(2012, 03, 20)));
    }

    public function testEncompasses()
    {
        $range1 = new DateRange(
            $start = new Date(2015, 01, 01),
            $end = new Date(2015, 05, 04)
        );

        $range2 = new DateRange(
            $start = new Date(2015, 03, 30),
            $end = new Date(2015, 06, 30)
        );

        $range3 = new DateRange(
            $start = new Date(2015, 02, 20),
            $end = new Date(2015, 04, 20)
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
        $range1 = new DateRange(
            $start = new Date(2015, 03, 05),
            $end = new Date(2015, 04, 05)
        );

        $range2 = new DateRange(
            $start = new Date(2015, 03, 30),
            $end = new Date(2015, 05, 30)
        );

        $range3 = new DateRange(
            $start = new Date(2015, 05, 20),
            $end = new Date(2015, 06, 20)
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
        $range1 = new DateRange(
            $start = new Date(2015, 03, 05),
            $end = new Date(2015, 04, 05)
        );

        $range2 = new DateRange(
            $start = new Date(2015, 03, 30),
            $end = new Date(2015, 05, 30)
        );

        $range3 = new DateRange(
            $start = new Date(2015, 05, 30),
            $end = new Date(2015, 06, 20)
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