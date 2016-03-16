<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money\Tests;

use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\CurrencyMismatchException;
use Dms\Common\Structure\Money\Money;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyTest extends CmsTestCase
{
    public function testNew()
    {
        $money = new Money(100, $currency = new Currency(Currency::AUD));

        $this->assertSame(100, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());
    }

    public function testFromString()
    {
        $money = Money::fromString('12.34', $currency = new Currency(Currency::AUD));

        $this->assertSame(1234, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());

        $money = Money::fromString('12.345', $currency = new Currency(Currency::USD));

        $this->assertSame(1235, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());
    }

    public function testNegate()
    {
        $money = (new Money(100, $currency = new Currency(Currency::AUD)))->negate();

        $this->assertSame(-100, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());
    }

    public function testAdd()
    {
        $currency = new Currency(Currency::AUD);
        $money = (new Money(100, $currency))->add(new Money(50, clone $currency));

        $this->assertSame(150, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());
    }

    public function testAddWithCurrencyMismatch()
    {
        $this->expectException(CurrencyMismatchException::class);

        (new Money(100, new Currency(Currency::AUD)))->add(new Money(50, new Currency(Currency::USD)));
    }

    public function testSubtract()
    {
        $currency = new Currency(Currency::AUD);
        $money = (new Money(100, $currency))->subtract(new Money(50, clone $currency));

        $this->assertSame(50, $money->getAmount());
        $this->assertEquals($currency, $money->getCurrency());
    }

    public function testSubtractWithCurrencyMismatch()
    {
        $this->expectException(CurrencyMismatchException::class);

        (new Money(100, new Currency(Currency::AUD)))->subtract(new Money(50, new Currency(Currency::USD)));
    }

    public function testMultiply()
    {
        $money = (new Money(100, $currency = new Currency(Currency::AUD)))->multiply(1.505, PHP_ROUND_HALF_UP);

        $this->assertSame(151, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());

        $money = (new Money(100, $currency = new Currency(Currency::AUD)))->multiply(1.505, PHP_ROUND_HALF_DOWN);

        $this->assertSame(150, $money->getAmount());
        $this->assertSame($currency, $money->getCurrency());
    }

    public function testMultiplyInvalidRoundingMode()
    {
        $this->expectException(InvalidArgumentException::class);

        (new Money(100, $currency = new Currency(Currency::AUD)))->multiply(1.505, 100);
    }

    public function testAsString()
    {
        $money = new Money(1251, new Currency(Currency::AUD));
        $this->assertSame('12.51', $money->asString());

        $money = new Money(9999, new Currency(Currency::AUD));
        $this->assertSame('99.99', $money->asString());

        $money = new Money(10000, new Currency(Currency::AUD));
        $this->assertSame('100.00', $money->asString());

        $money = new Money(10001, new Currency(Currency::AUD));
        $this->assertSame('100.01', $money->asString());

        $money = new Money(10010, new Currency(Currency::AUD));
        $this->assertSame('100.10', $money->asString());

        $money = new Money(100, new Currency(Currency::AUD));
        $this->assertSame('1.00', $money->asString());

        $money = new Money(0, new Currency(Currency::AUD));
        $this->assertSame('0.00', $money->asString());
    }
}