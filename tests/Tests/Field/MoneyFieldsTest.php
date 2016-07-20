<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\Form\MoneyType;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Form\Field\Type\FieldType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyFieldsTest extends CmsTestCase
{
    public function testMoney()
    {
        /** @var MoneyType $type */
        $type = Field::forType()->money()
            ->build()
            ->getType();

        $this->assertInstanceOf(MoneyType::class, $type);
        $this->assertEquals(array_values(Currency::getOptions()), $type->getForm()->getField('currency')->getType()->get(FieldType::ATTR_OPTIONS)->getAllValues());
    }
    
    public function testMoneyWithValidCurrencies()
    {
        $type = Field::forType()->money()
            ->validCurrencies(new Currency(Currency::AUD), new Currency(Currency::NZD))
            ->build()
            ->getType();

        $this->assertInstanceOf(MoneyType::class, $type);
        $this->assertEquals([Currency::AUD, Currency::NZD], $type->getForm()->getField('currency')->getType()->get(FieldType::ATTR_OPTIONS)->getAllValues());
    }
}