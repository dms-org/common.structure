<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\Persistence\DateTimeMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new DateTimeMapper('datetime');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['datetime' => new \DateTimeImmutable('1970-01-01 00:00:00')], DateTime::fromString('1970-01-01 00:00:00')],
                [['datetime' => new \DateTimeImmutable('1997-05-04 12:13:14')], DateTime::fromString('1997-05-04 12:13:14')],
                [['datetime' => new \DateTimeImmutable('2042-10-12 00:00:01')], DateTime::fromString('2042-10-12 00:00:01')],
                [['datetime' => new \DateTimeImmutable('0002-4-6 00:05:00')], DateTime::fromString('0002-4-6 00:05:00')],
        ];
    }
}