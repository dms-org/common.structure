<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\Date;
use Iddigital\Cms\Common\Structure\DateTime\DateRange;
use Iddigital\Cms\Common\Structure\DateTime\Persistence\DateRangeMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new DateRangeMapper('start', 'end');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['start' => new \DateTimeImmutable('1970-01-01 00:00:00'), 'end' => new \DateTimeImmutable('2000-01-01 00:00:00')],
                        new DateRange(new Date(1970, 1, 1), new Date(2000, 1, 1))
                ],
                [
                        ['start' => new \DateTimeImmutable('1997-05-04 00:00:00'), 'end' => new \DateTimeImmutable('2000-04-28 00:00:00')],
                        new DateRange(new Date(1997, 05, 04), new Date(2000, 04, 28))
                ],
        ];
    }
}