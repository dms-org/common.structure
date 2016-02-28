<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\Form\DateTimeType;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\Field;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateOrTimeFieldsTest extends CmsTestCase
{
    public function testTime()
    {
        $type = Field::forType()->time()
                ->min(new TimeOfDay(1))
                ->greaterThan(new TimeOfDay(0))
                ->max(new TimeOfDay(12))
                ->lessThan(new TimeOfDay(13))
                ->build()
                ->getType();

        $this->assertArraySubset([
                DateTimeType::ATTR_MIN          => new \DateTimeImmutable('1970-01-01 01:00:00'),
                DateTimeType::ATTR_GREATER_THAN => new \DateTimeImmutable('1970-01-01 00:00:00'),
                DateTimeType::ATTR_MAX          => new \DateTimeImmutable('1970-01-01 12:00:00'),
                DateTimeType::ATTR_LESS_THAN    => new \DateTimeImmutable('1970-01-01 13:00:00'),
        ], $type->attrs());
    }

    public function testDate()
    {
        $type = Field::forType()->date()
                ->min(new Date(2000, 1, 1))
                ->greaterThan(new Date(1999, 1, 1))
                ->max(new Date(2010, 1, 1))
                ->lessThan(new Date(2009, 1, 1))
                ->build()
                ->getType();

        $this->assertArraySubset([
                DateTimeType::ATTR_MIN          => new \DateTimeImmutable('2000-01-01 00:00:00'),
                DateTimeType::ATTR_GREATER_THAN => new \DateTimeImmutable('1999-01-01 00:00:00'),
                DateTimeType::ATTR_MAX          => new \DateTimeImmutable('2010-01-01 00:00:00'),
                DateTimeType::ATTR_LESS_THAN    => new \DateTimeImmutable('2009-01-01 00:00:00'),
        ], $type->attrs());
    }

    public function testDateTime()
    {
        $type = Field::forType()->dateTime()
                ->min(DateTime::fromString('2000-01-01 00:00:00'))
                ->greaterThan(DateTime::fromString('1999-01-01 00:00:00'))
                ->max(DateTime::fromString('2010-01-01 00:00:00'))
                ->lessThan(DateTime::fromString('2009-01-01 00:00:00'))
                ->build()
                ->getType();

        $this->assertArraySubset([
                DateTimeType::ATTR_MIN          => new \DateTimeImmutable('2000-01-01 00:00:00'),
                DateTimeType::ATTR_GREATER_THAN => new \DateTimeImmutable('1999-01-01 00:00:00'),
                DateTimeType::ATTR_MAX          => new \DateTimeImmutable('2010-01-01 00:00:00'),
                DateTimeType::ATTR_LESS_THAN    => new \DateTimeImmutable('2009-01-01 00:00:00'),
        ], $type->attrs());
    }

    public function testTimezonedDateTime()
    {
        $type = Field::forType()->dateTimeWithTimezone()
                ->min(TimezonedDateTime::fromString('2000-01-01 00:00:00', 'UTC'))
                ->greaterThan(TimezonedDateTime::fromString('1999-01-01 00:00:00', 'Australia/Melbourne'))
                ->max(TimezonedDateTime::fromString('2010-01-01 00:00:00', 'UTC'))
                ->lessThan(TimezonedDateTime::fromString('2009-01-01 00:00:00', 'Australia/Melbourne'))
                ->build()
                ->getType();

        $this->assertArraySubset([
                DateTimeType::ATTR_MIN          => new \DateTimeImmutable('2000-01-01 00:00:00', new \DateTimeZone('UTC')),
                DateTimeType::ATTR_GREATER_THAN => new \DateTimeImmutable('1999-01-01 00:00:00', new \DateTimeZone('Australia/Melbourne')),
                DateTimeType::ATTR_MAX          => new \DateTimeImmutable('2010-01-01 00:00:00', new \DateTimeZone('UTC')),
                DateTimeType::ATTR_LESS_THAN    => new \DateTimeImmutable('2009-01-01 00:00:00', new \DateTimeZone('Australia/Melbourne')),
        ], $type->attrs());
    }
}