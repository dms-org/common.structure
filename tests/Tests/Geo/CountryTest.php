<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Tests\Geo;

use Dms\Common\Structure\Geo\Country;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\InvalidEnumValueException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class CountryTest extends CmsTestCase
{
    public function testEnum()
    {
        $enum = new Country(Country::AU);

        $this->assertSame(Country::AU, $enum->getValue());
        $this->assertSame('AU', $enum->getAlpha2Code());
        $this->assertSame('AUS', $enum->getAlpha3Code());
        $this->assertSame(36, $enum->getNumericCode());
        $this->assertSame(null, $enum->getLongName());
        $this->assertSame('Australia', $enum->getShortName());
        $this->assertSame('Australia', $enum->getLongNameWithFallback());
    }

    public function testInvalidCountry()
    {
        $this->expectException(InvalidEnumValueException::class);
        new Country('BAD_CODE');
    }

    public function testShortNameMap()
    {
        $shortNameMap = Country::getShortNameMap();

        $this->assertSame(array_values(Country::getOptions()), array_keys($shortNameMap));
        $this->assertContainsOnly('string', $shortNameMap);
    }

    public function testFromShortName()
    {
        $enum = Country::fromShortName('Australia');

        $this->assertSame(Country::AU, $enum->getValue());

        $this->assertThrows(function () {
            Country::fromShortName('Not a valid country');
        }, InvalidArgumentException::class);
    }
}