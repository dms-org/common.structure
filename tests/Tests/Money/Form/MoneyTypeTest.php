<?php

namespace Dms\Common\Structure\Tests\Money\Form;

use Dms\Common\Structure\Geo\Form\LatLngType;
use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\Form\MoneyType;
use Dms\Common\Structure\Money\Money;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\FloatValidator;
use Dms\Core\Form\Field\Processor\Validator\GreaterThanOrEqualValidator;
use Dms\Core\Form\Field\Processor\Validator\LessThanOrEqualValidator;
use Dms\Core\Form\Field\Processor\Validator\OneOfValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new MoneyType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Money::type()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['abc', [new Message(TypeValidator::MESSAGE, ['type' => Type::arrayOf(Type::mixed())->nullable()->asTypeString()])]],
                [
                        [],
                        [
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Amount', 'input' => null]),
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Currency', 'input' => null]),
                        ],
                ],
                [
                        ['amount' => 'abc', 'currency' => '11abc'],
                        [
                                new Message(FloatValidator::MESSAGE, ['field' => 'Amount', 'input' => 'abc']),
                                new Message(OneOfValidator::MESSAGE, ['field' => 'Currency', 'input' => '11abc', 'options' => implode(', ', array_keys(Currency::getCurrencies()))]),
                        ],
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                [['amount' => '5', 'currency' => 'USD'], new Money(500, new Currency(Currency::USD))],
                [['amount' => '10.02', 'currency' => 'AUD'], new Money(1002, new Currency(Currency::AUD))],
                [['amount' => '99.995', 'currency' => 'AUD'], new Money(10000, new Currency(Currency::AUD))],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
            [new Money(500, new Currency(Currency::USD)), ['amount' => '5.00', 'currency' => 'USD']],
            [new Money(1002, new Currency(Currency::AUD)), ['amount' => '10.02', 'currency' => 'AUD']],
            [new Money(10000, new Currency(Currency::AUD)), ['amount' => '100.00', 'currency' => 'AUD']],
        ];
    }
}