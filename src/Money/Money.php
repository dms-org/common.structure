<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;
use Dms\Core\Util\Debug;

/**
 * The money value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Money extends ValueObject
{
    const AMOUNT = 'amount';
    const CURRENCY = 'currency';

    private static $roundingModes = [
        PHP_ROUND_HALF_UP,
        PHP_ROUND_HALF_DOWN,
        PHP_ROUND_HALF_ODD,
        PHP_ROUND_HALF_EVEN,
    ];

    /**
     * @var int
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * Money constructor.
     *
     * @param int      $amount
     * @param Currency $currency
     */
    public function __construct(int $amount, Currency $currency)
    {
        parent::__construct();
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * Creates a Money object from a string such as "12.34"
     *
     * This method is designed to take into account the errors that can arise
     * from manipulating floating point numbers.
     *
     * If the number of decimals in the string is higher than the currency's
     * number of fractional digits then the value will be rounded to the
     * currency's number of fractional digits.
     *
     * @param string   $value
     * @param Currency $currency
     *
     * @return Money
     */
    public static function fromString(string $value, Currency $currency)
    {
        return new Money(
            intval(
                round(
                    $currency->getSubUnit() *
                    round(
                        $value,
                        $currency->getDefaultFractionDigits(),
                        PHP_ROUND_HALF_UP
                    ),
                    0,
                    PHP_ROUND_HALF_UP
                )
            ),
            $currency
        );
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->amount)->asInt();

        $class->property($this->currency)->asObject(Currency::class);
    }

    /**
     * @return int
     */
    public function getAmount() : int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Money
     */
    public function withAmount(int $amount) : Money
    {
        return new Money($amount, $this->currency);
    }

    /**
     * @return Currency
     */
    public function getCurrency() : Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     *
     * @return Money
     */
    public function withCurrency(Currency $currency) : Money
    {
        return new Money($this->amount, $currency);
    }

    /**
     * @param float $factor
     * @param int   $roundingMode
     *
     * @return Money
     * @throws InvalidArgumentException
     */
    public function multiply(float $factor, int $roundingMode) : Money
    {
        if (!in_array($roundingMode, self::$roundingModes, true)) {
            throw InvalidArgumentException::format(
                'Invalid rounding mode supplied to %s: expecting one of (%s), %s given',
                __METHOD__, Debug::formatValues(self::$roundingModes), $roundingMode
            );
        }

        return new Money((int)round($this->amount * $factor, 0, $roundingMode), $this->currency);
    }

    /**
     * @return Money
     */
    public function negate() : Money
    {
        return new Money(-$this->amount, $this->currency);
    }

    /**
     * @param Money $money
     *
     * @return Money
     * @throws CurrencyMismatchException
     */
    public function add(Money $money) : Money
    {
        $this->verifySameCurrency(__METHOD__, $money);

        return new Money($this->amount + $money->amount, $this->currency);
    }

    /**
     * @param Money $money
     *
     * @return Money
     * @throws CurrencyMismatchException
     */
    public function subtract(Money $money) : Money
    {
        $this->verifySameCurrency(__METHOD__, $money);

        return $this->add($money->negate());
    }

    /**
     * Returns the monetary value as string.
     *
     * @return string
     */
    public function asString() : string
    {
        $fractionDigits = $this->currency->getDefaultFractionDigits();

        $wholePart = substr((string)$this->amount, 0, -$fractionDigits) ?: '0';

        $fractionalPart = str_pad(substr((string)$this->amount, -$fractionDigits), $fractionDigits, '0', STR_PAD_LEFT);

        return $wholePart . '.' . $fractionalPart;
    }

    private function verifySameCurrency(string $method, Money $money)
    {
        if (!$money->currency->is($this->currency)) {
            throw CurrencyMismatchException::format(
                'Invalid money supplied to %s: currency must match expected type %s, %s given',
                $method, $this->currency->getCurrencyCode(), $money->currency->getCurrencyCode()
            );
        }
    }
}
