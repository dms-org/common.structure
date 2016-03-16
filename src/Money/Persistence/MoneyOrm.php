<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Money\Persistence;

use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;
use Dms\Common\Structure\Money\Money;

/**
 * The money orm.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->valueObjects([
            Money::class => MoneyMapper::class
        ]);
    }
}