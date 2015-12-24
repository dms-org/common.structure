<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\Persistence\TimeOfDayMapper;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDayMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new TimeOfDayMapper('time');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['time' => new \DateTimeImmutable('1970-01-01 12:00:00')], new TimeOfDay(12, 0, 0)],
                [['time' => new \DateTimeImmutable('1970-01-01 11:11:11')], new TimeOfDay(11, 11, 11)],
                [['time' => new \DateTimeImmutable('1970-01-01 23:59:59')], new TimeOfDay(23, 59, 59)],
        ];
    }
}