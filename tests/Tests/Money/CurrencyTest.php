<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money\Tests;

use Dms\Common\Structure\Money\Currency;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class CurrencyTest extends CmsTestCase
{
    public function testNew()
    {
        $currency = new Currency(Currency::AUD);

        $this->assertSame('AUD', $currency->getValue());
        $this->assertSame('AUD', $currency->getCurrencyCode());
        $this->assertSame('Australian Dollar', $currency->getDisplayName());
        $this->assertSame(100, $currency->getSubUnit());
        $this->assertSame(2, $currency->getDefaultFractionDigits());
    }

    public function testNameMap()
    {
        $this->assertSame(count(Currency::getCurrencies()), count(Currency::getNameMap()));
        $this->assertGreaterThan(100, count(Currency::getCurrencies()));
        $this->assertGreaterThan(100, count(Currency::getNameMap()));
    }
}