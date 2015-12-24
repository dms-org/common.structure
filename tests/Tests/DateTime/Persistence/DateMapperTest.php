<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\Persistence\DateMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new DateMapper('date');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['date' => new \DateTimeImmutable('1970-01-01 00:00:00')], new Date(1970, 1, 1)],
                [['date' => new \DateTimeImmutable('1997-05-04 00:00:00')], new Date(1997, 5, 4)],
                [['date' => new \DateTimeImmutable('2042-10-12 00:00:00')], new Date(2042, 10, 12)],
                [['date' => new \DateTimeImmutable('0002-4-6 00:00:00')], new Date(2, 4, 6)],
        ];
    }
}