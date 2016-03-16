<?php

namespace Dms\Common\Structure\Tests\Money\Persistence;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Geo\Persistence\LatLngMapper;
use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\Money;
use Dms\Common\Structure\Money\Persistence\MoneyMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new MoneyMapper('amount', 'currency');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['amount' => 10, 'currency' => 'AUD'], new Money(10, new Currency(Currency::AUD))],
                [['amount' => 5005, 'currency' => 'USD'], new Money(5005, new Currency(Currency::USD))],
        ];
    }
}