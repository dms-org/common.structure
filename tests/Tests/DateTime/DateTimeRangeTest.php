<?php

namespace Dms\Common\Structure\Tests\DateTime;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeTest extends DateOrTimeRangeTest
{
    public function testNew()
    {
        $range = new DateTimeRange(
                $start = DateTime::fromString('2015-03-05'),
                $end = DateTime::fromString('2015-04-05')
        );

        $this->assertSame($start, $range->getStart());
        $this->assertSame($end, $range->getEnd());
    }

    public function testStartAfterEnd()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new DateTimeRange(
                $start = DateTime::fromString('2015-04-06'),
                $end = DateTime::fromString('2015-04-05')
        );
    }

    public function testContains()
    {
        $range = new DateTimeRange(
                $start = DateTime::fromString('2015-03-05'),
                $end = DateTime::fromString('2015-04-05')
        );

        $this->assertSame(true, $range->contains($start));
        $this->assertSame(true, $range->contains(DateTime::fromString('2015-03-20')));
        $this->assertSame(true, $range->contains($end));

        $this->assertSame(false, $range->contains(DateTime::fromString('2015-03-04')));
        $this->assertSame(false, $range->contains(DateTime::fromString('2015-04-06')));
        $this->assertSame(false, $range->contains(DateTime::fromString('2012-03-20')));
    }

    public function testContainExclusive()
    {
        $range = new DateTimeRange(
                $start = DateTime::fromString('2015-03-05'),
                $end = DateTime::fromString('2015-04-05')
        );

        $this->assertSame(false, $range->containsExclusive($start));
        $this->assertSame(true, $range->containsExclusive(DateTime::fromString('2015-03-06')));
        $this->assertSame(true, $range->containsExclusive(DateTime::fromString('2015-03-20')));
        $this->assertSame(false, $range->containsExclusive($end));

        $this->assertSame(false, $range->containsExclusive(DateTime::fromString('2015-03-04')));
        $this->assertSame(false, $range->containsExclusive(DateTime::fromString('2015-04-06')));
        $this->assertSame(false, $range->containsExclusive(DateTime::fromString('2012-03-20')));
    }

    public function testEncompasses()
    {
        $range1 = new DateTimeRange(
            $start = DateTime::fromString('2015-01-05'),
            $end = DateTime::fromString('2015-06-05')
        );

        $range2 = new DateTimeRange(
            $start = DateTime::fromString('2015-03-30'),
            $end = DateTime::fromString('2015-08-30')
        );

        $range3 = new DateTimeRange(
            $start = DateTime::fromString('2015-03-20'),
            $end = DateTime::fromString('2015-04-20')
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
        $range1 = new DateTimeRange(
                $start = DateTime::fromString('2015-03-05'),
                $end = DateTime::fromString('2015-04-05')
        );

        $range2 = new DateTimeRange(
                $start = DateTime::fromString('2015-03-30'),
                $end = DateTime::fromString('2015-05-30')
        );

        $range3 = new DateTimeRange(
                $start = DateTime::fromString('2015-05-20'),
                $end = DateTime::fromString('2015-06-20')
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