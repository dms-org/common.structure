<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\Money\Form\MoneyType;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MoneyFieldsTest extends CmsTestCase
{
    public function testMoney()
    {
        $type = Field::forType()->money()
            ->build()
            ->getType();

        $this->assertInstanceOf(MoneyType::class, $type);
    }
}