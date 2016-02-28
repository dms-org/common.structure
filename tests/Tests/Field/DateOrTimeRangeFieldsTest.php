<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\DateTime\Form\DateRangeType;
use Dms\Common\Structure\DateTime\Form\DateTimeRangeType;
use Dms\Common\Structure\DateTime\Form\TimeRangeType;
use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeRangeType;
use Dms\Common\Structure\Field;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateOrTimeRangeFieldsTest extends CmsTestCase
{
    public function testTimeRange()
    {
        $type = Field::forType()->timeRange()
                ->build()
                ->getType();

        $this->assertInstanceOf(TimeRangeType::class, $type);
    }

    public function testDateRange()
    {
        $type = Field::forType()->dateRange()
                ->build()
                ->getType();

        $this->assertInstanceOf(DateRangeType::class, $type);
    }

    public function testDateTimeRange()
    {
        $type = Field::forType()->dateTimeRange()
                ->build()
                ->getType();

        $this->assertInstanceOf(DateTimeRangeType::class, $type);
    }

    public function testTimezonedDateTimeRange()
    {
        $type = Field::forType()->dateTimeWithTimezoneRange()
                ->build()
                ->getType();

        $this->assertInstanceOf(TimezonedDateTimeRangeType::class, $type);
    }
}