<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\Persistence\TimezonedDateTimeRangeMapper;
use Iddigital\Cms\Common\Structure\DateTime\TimeZonedDateTime;
use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRangeMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new TimezonedDateTimeRangeMapper('start', 'start_timezone', 'end', 'end_timezone');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        [
                                'start'          => new \DateTimeImmutable('1970-01-01 10:00:00'),
                                'start_timezone' => 'UTC',
                                'end'            => new \DateTimeImmutable('2000-01-01 00:00:00'),
                                'end_timezone'   => 'Australia/Melbourne',
                        ],
                        new TimezonedDateTimeRange(
                                TimeZonedDateTime::fromString('1970-1-1 10:00:00', 'UTC'),
                                TimeZonedDateTime::fromString('2000-1-1', 'Australia/Melbourne')
                        )
                ],
        ];
    }
}