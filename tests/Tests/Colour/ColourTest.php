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
class ColourTest extends CmsTestCase
{
    public function testNew()
    {
        $colour = new Colour(10, 100, 150);

        $this->assertSame(10, $colour->getRed());
        $this->assertSame(100, $colour->getGreen());
        $this->assertSame(150, $colour->getBlue());

        $this->assertThrows(function () {
            new Colour(-1, 100, 150);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new Colour(256, 100, 150);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new Colour(10, 100, 300);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new Colour(10, -48, 45);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new Colour('abc', 10, 10);
        }, InvalidPropertyValueException::class);
    }

    public function testFromRgbString()
    {
        $colour = Colour::fromRgbString('rgb(10, 100, 150)');

        $this->assertSame(10, $colour->getRed());
        $this->assertSame(100, $colour->getGreen());
        $this->assertSame(150, $colour->getBlue());

        $this->assertThrows(function () {
            Colour::fromRgbString('rgb(300, 100, 150)');
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            Colour::fromRgbString('rgb(abv, 100, 150)');
        }, InvalidArgumentException::class);
    }

    public function testToRgbString()
    {
        $colour = new Colour(10, 100, 150);

        $this->assertSame('rgb(10, 100, 150)', $colour->toRgbString());
    }

    public function testFromHexString()
    {
        $colour = Colour::fromHexString('#0A6496');

        $this->assertSame(10, $colour->getRed());
        $this->assertSame(100, $colour->getGreen());
        $this->assertSame(150, $colour->getBlue());

        $this->assertThrows(function () {
            Colour::fromHexString('rgb(300, 100, 150)');
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            Colour::fromHexString('#yyuttu');
        }, InvalidArgumentException::class);
    }

    public function testToHexString()
    {
        $colour = new Colour(10, 100, 150);

        $this->assertSame('#0a6496', $colour->toHexString());
    }

    public function testWithTransparency()
    {
        $colour = new Colour(10, 100, 150);
        $transparent = $colour->withTransparency(.5);

        $this->assertInstanceOf(TransparentColour::class, $transparent);
        $this->assertEquals($colour, $transparent->withoutTransparency());
        $this->assertSame(.5, $transparent->getAlpha());
    }
}