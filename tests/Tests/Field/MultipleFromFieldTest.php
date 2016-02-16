<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Form\Field\Type\ArrayOfType;
use Dms\Core\Form\Field\Type\StringType;
use Dms\Core\Form\InvalidInputException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MultipleFromFieldTest extends CmsTestCase
{
    public function testMultipleFromField()
    {
        $field = Field::forType()->multipleFrom([
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ])->build();

        /** @var ArrayOfType $type */
        $type = $field->getType();

        $this->assertInstanceOf(ArrayOfType::class, $type);
        $this->assertInstanceOf(StringType::class, $type->getElementType());
        $this->assertSame(true, $type->getElementType()->get(StringType::ATTR_REQUIRED));
        $this->assertSame(['a', 'b', 'c',], $type->getElementType()->get(StringType::ATTR_OPTIONS)->getAllValues());

        $this->assertSame(['a', 'b'], $field->process(['a', 'b']));
        $this->assertSame(['a', 'c'], $field->process(['a', 'c']));
        $this->assertSame(['c'], $field->process(['c']));

        $this->assertThrows(function () use ($field) {
            $field->process(['a', 'b', 'd']);
        }, InvalidInputException::class);
    }
}