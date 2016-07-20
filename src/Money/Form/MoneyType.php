<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money\Form;

use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\Money;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IForm;

/**
 * The money field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyType extends InnerFormType
{
    const ATTR_VALID_CURRENCIES = 'validCurrencies';

    public function __construct()
    {
        parent::__construct(self::form());
    }

    protected function initializeFromCurrentAttributes()
    {
        $this->attributes[self::ATTR_FORM] = self::form($this->get(self::ATTR_VALID_CURRENCIES));
        
        parent::initializeFromCurrentAttributes();
    }


    /**
     * @param Currency[]|null $currencies
     *
     * @return IForm
     * @throws \Dms\Core\Form\ConflictingFieldNameException
     */
    public static function form(array $currencies = null) : IForm
    {
        if ($currencies === null) {
            $currencies = Currency::getAll();
        }

        $nameMap = Currency::getNameMap();
        $filteredNameMap = [];

        foreach ($currencies as $currency) {
            $filteredNameMap[$currency->getValue()] = $nameMap[$currency->getValue()];
        }


        $currencyField = Field::name('currency')->label('Currency')
            ->enum(Currency::class, $filteredNameMap)
            ->required();

        return Form::create()
            ->section('Money', [
                Field::name('amount')->label('Amount')
                    ->decimal()
                    ->required(),
                $currencyField,
            ])
            ->build();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors() : array
    {
        return array_merge(parent::buildProcessors(), [
            new CustomProcessor(
                Money::type(),
                function ($input) {
                    return Money::fromString((string)$input['amount'], $input['currency']);
                },
                function (Money $money) {
                    return [
                        'amount'   => (float)$money->asString(),
                        'currency' => $money->getCurrency(),
                    ];
                }
            ),
        ]);
    }
}