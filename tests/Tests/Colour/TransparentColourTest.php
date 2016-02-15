<?php

namespace Dms\Common\Structure\Tests\Colour;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Exception\TypeMismatchException;
use Dms\Core\Model\Object\InvalidPropertyValueException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TransparentColourTest extends CmsTestCase
{
    public function testNew()
    {
        $colour = new TransparentColour($innerColour = new Colour(10, 100, 150), .5);

        $this->assertSame(10, $colour->getRed());
        $this->assertSame(100, $colour->getGreen());
        $this->assertSame(150, $colour->getBlue());
        $this->assertSame(.5, $colour->getAlpha());
        $this->assertSame($innerColour, $colour->withoutTransparency());

        $this->assertThrows(function () {
            new TransparentColour(new Colour(10, 100, 150), -0.01);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new TransparentColour(new Colour(10, 100, 150), 1.01);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new TransparentColour(new Colour(10, 100, 150), 'abc');
        }, \TypeError::class);
    }

    public function testFromRgba()
    {
        $colour = TransparentColour::fromRgba(10, 100, 150, .5);

        $this->assertSame(10, $colour->getRed());
        $this->assertSame(100, $colour->getGreen());
        $this->assertSame(150, $colour->getBlue());
        $this->assertSame(.5, $colour->getAlpha());
    }

    public function testFromRgbaString()
    {
        $colour = TransparentColour::fromRgbaString('rgba(10, 100, 150, .5)');

        $this->assertSame(10, $colour->getRed());
        $this->assertSame(100, $colour->getGreen());
        $this->assertSame(150, $colour->getBlue());
        $this->assertSame(.5, $colour->getAlpha());

        $this->assertThrows(function () {
            TransparentColour::fromRgbaString('rgba(-10, 100, 150, .5)');
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            TransparentColour::fromRgbaString('rgba(10, 100, 150, 2)');
        }, InvalidArgumentException::class);
    }

    public function testToRgbaString()
    {
        $colour = TransparentColour::fromRgba(10, 100, 150, .5);

        $this->assertSame('rgba(10, 100, 150, 0.5)', $colour->toRgbaString());
    }
}