<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTime;
use Iddigital\Cms\Common\Structure\DateTime\Persistence\TimezonedDateTimeMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new TimezonedDateTimeMapper();
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['datetime' => new \DateTimeImmutable('1970-01-01 00:00:00', new \DateTimeZone('UTC')), 'timezone' => 'UTC'],
                        TimezonedDateTime::fromString('1970-01-01 00:00:00', 'UTC')
                ],
                [
                        ['datetime' => new \DateTimeImmutable('1997-05-04 12:13:14', new \DateTimeZone('UTC')), 'timezone' => 'Australia/Melbourne'],
                        TimezonedDateTime::fromString('1997-05-04 12:13:14', 'Australia/Melbourne')
                ],
                [
                        ['datetime' => new \DateTimeImmutable('2022-10-12 00:00:01', new \DateTimeZone('UTC')), 'timezone' => 'Europe/Berlin'],
                        TimezonedDateTime::fromString('2022-10-12 00:00:01', 'Europe/Berlin')
                ],
                [
                        ['datetime' => new \DateTimeImmutable('1975-4-6 00:05:00', new \DateTimeZone('UTC')), 'timezone' => 'America/New_York'],
                        TimezonedDateTime::fromString('1975-4-6 00:05:00', 'America/New_York')
                ],
        ];
    }
}