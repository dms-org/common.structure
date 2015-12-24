<?php

namespace Dms\Common\Structure\Tests\DateTime;

use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRangeTest extends DateOrTimeRangeTest
{
    public function testNew()
    {
        $range = new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-03-05', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-04-05', 'UTC')
        );

        $this->assertSame($start, $range->getStart());
        $this->assertSame($end, $range->getEnd());
    }

    public function testStartAfterEnd()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-04-06', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-04-05', 'UTC')
        );
    }

    public function testContains()
    {
        $range = new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-03-05', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-04-05', 'UTC')
        );

        $this->assertSame(true, $range->contains($start));
        $this->assertSame(true, $range->contains(TimezonedDateTime::fromString('2015-03-20', 'UTC')));
        $this->assertSame(true, $range->contains($end));

        $this->assertSame(false, $range->contains(TimezonedDateTime::fromString('2015-03-04', 'UTC')));
        $this->assertSame(false, $range->contains(TimezonedDateTime::fromString('2015-04-06', 'UTC')));
        $this->assertSame(false, $range->contains(TimezonedDateTime::fromString('2012-03-20', 'UTC')));
    }

    public function testContainExclusive()
    {
        $range = new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-03-05', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-04-05', 'UTC')
        );

        $this->assertSame(false, $range->containsExclusive($start));
        $this->assertSame(true, $range->containsExclusive(TimezonedDateTime::fromString('2015-03-06', 'UTC')));
        $this->assertSame(true, $range->containsExclusive(TimezonedDateTime::fromString('2015-03-20', 'UTC')));
        $this->assertSame(false, $range->containsExclusive($end));

        $this->assertSame(false, $range->containsExclusive(TimezonedDateTime::fromString('2015-03-04', 'UTC')));
        $this->assertSame(false, $range->containsExclusive(TimezonedDateTime::fromString('2015-04-06', 'UTC')));
        $this->assertSame(false, $range->containsExclusive(TimezonedDateTime::fromString('2012-03-20', 'UTC')));
    }

    public function testOverlaps()
    {
        $range1 = new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-03-05', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-04-05', 'UTC')
        );

        $range2 = new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-03-30', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-05-30', 'UTC')
        );

        $range3 = new TimezonedDateTimeRange(
                $start = TimezonedDateTime::fromString('2015-05-20', 'UTC'),
                $end = TimezonedDateTime::fromString('2015-06-20', 'UTC')
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