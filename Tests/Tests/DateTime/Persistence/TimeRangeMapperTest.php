<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\Persistence\TimeRangeMapper;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Common\Structure\DateTime\TimeRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRangeMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new TimeRangeMapper('start', 'end');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['start' => new \DateTimeImmutable('1970-01-01 12:00:00'), 'end' => new \DateTimeImmutable('1970-01-01 12:30:32')],
                        new TimeRange(new TimeOfDay(12, 0, 0), new TimeOfDay(12, 30, 32)),
                ],
                [
                        ['start' => new \DateTimeImmutable('1970-01-01 01:01:01'), 'end' => new \DateTimeImmutable('1970-01-01 23:59:59')],
                        new TimeRange(new TimeOfDay(1, 1, 1), new TimeOfDay(23, 59, 59)),
                ],
        ];
    }
}