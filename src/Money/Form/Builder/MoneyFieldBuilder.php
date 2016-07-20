<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money\Form\Builder;

use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\Form\MoneyType;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;

/**
 * The money field builder
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyFieldBuilder extends FieldBuilderBase
{
    /**
     * Validates the selected currency is one of the supplied values.
     *
     * @param Currency[] $currencies
     *
     * @return static
     */
    public function validCurrencies(Currency ... $currencies)
    {
        return $this->attr(MoneyType::ATTR_VALID_CURRENCIES, $currencies);
    }
}