<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Colour\Form\ColourType;
use Dms\Common\Structure\Colour\Form\TransparentColourType;
use Dms\Common\Structure\Field;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ColourFieldsTest extends CmsTestCase
{
    public function testColour()
    {
        $type = Field::forType()->colour()
            ->build()
            ->getType();

        $this->assertInstanceOf(ColourType::class, $type);
    }

    public function testColourWithTransparency()
    {
        $type = Field::forType()->colourWithTransparency()
            ->build()
            ->getType();

        $this->assertInstanceOf(TransparentColourType::class, $type);
    }
}