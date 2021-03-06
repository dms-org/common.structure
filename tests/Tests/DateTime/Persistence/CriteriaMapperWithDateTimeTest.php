<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject\EntityWithDateTimeMapper;
use Dms\Core\Persistence\Db\Criteria\CriteriaMapper;
use Dms\Core\Persistence\Db\Mapping\CustomOrm;
use Dms\Core\Persistence\Db\Query\Expression\Expr;
use Dms\Core\Tests\Persistence\Db\Integration\Criteria\CriteriaMapperTestBase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class CriteriaMapperWithDateTimeTest extends CriteriaMapperTestBase
{

    protected function buildMapper()
    {
        return new CriteriaMapper(new EntityWithDateTimeMapper(CustomOrm::from([])));
    }

    public function testWhereEquals()
    {
        $criteria = $this->mapper->newCriteria()
                ->where('datetime', '=', DateTime::fromString('2000-01-01 10:11'));

        $this->assertMappedSelect($criteria,
                $this->selectAllColumns()
                        ->where(Expr::equal($this->column('datetime'),
                                Expr::param($this->columnType('datetime'), new \DateTimeImmutable('2000-01-01 10:11:00'))))
        );
    }

    public function testWhereGreaterThan()
    {
        $criteria = $this->mapper->newCriteria()
                ->where('datetime', '>', DateTime::fromString('2000-01-01 10:11'));

        $this->assertMappedSelect($criteria,
                $this->selectAllColumns()
                        ->where(Expr::greaterThan($this->column('datetime'),
                                Expr::param($this->columnType('datetime'), new \DateTimeImmutable('2000-01-01 10:11:00'))))
        );
    }

    public function testOrderBy()
    {
        $criteria = $this->mapper->newCriteria()
                ->orderByAsc('datetime');

        $this->assertMappedSelect($criteria,
                $this->selectAllColumns()
                        ->orderByAsc($this->column('datetime'))
        );
    }
}