<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Common\Structure\DateTime\Persistence\DateTimeRangeMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new DateTimeRangeMapper('start', 'end');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['start' => new \DateTimeImmutable('1970-01-01 10:00:00'), 'end' => new \DateTimeImmutable('2000-01-01 00:00:00')],
                        new DateTimeRange(DateTime::fromString('1970-1-1 10:00:00'), DateTime::fromString('2000-1-1'))
                ],
                [
                        ['start' => new \DateTimeImmutable('1997-05-04 00:00:00'), 'end' => new \DateTimeImmutable('2000-04-28 00:00:00')],
                        new DateTimeRange(DateTime::fromString('1997-05-04'), DateTime::fromString('2000-04-28'))
                ],
        ];
    }
}