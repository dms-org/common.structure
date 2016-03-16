<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money\Persistence;

use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;
use Dms\Common\Structure\Money\Currency;
use Dms\Common\Structure\Money\Money;

/**
 * The money value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $amountColumnName;

    /**
     * @var string
     */
    protected $currencyColumnName;

    /**
     * MoneyMapper constructor.
     *
     * @param string $amountColumnName
     * @param string $currencyColumnName
     */
    public function __construct(string $amountColumnName = 'amount', string $currencyColumnName = 'currency')
    {
        $this->amountColumnName   = $amountColumnName;
        $this->currencyColumnName = $currencyColumnName;
        parent::__construct();
    }

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(Money::class);

        $map->property(Money::AMOUNT)->to($this->amountColumnName)->asInt();

        // We don't use the typical enum mapper as their are too many
        // currency codes to reasonably map to an enum column
        $map->property(Money::CURRENCY)
            ->mappedVia(function (Currency $currency) : string {
                return $currency->getValue();
            }, function (string $code) : Currency {
                return new Currency($code);
            })
            ->to($this->currencyColumnName)
            ->asVarchar(5);
    }
}