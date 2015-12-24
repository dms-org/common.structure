<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\Persistence\TimezonedDateTimeRangeMapper;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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
                                TimezonedDateTime::fromString('1970-1-1 10:00:00', 'UTC'),
                                TimezonedDateTime::fromString('2000-1-1', 'Australia/Melbourne')
                        )
                ],
        ];
    }
}