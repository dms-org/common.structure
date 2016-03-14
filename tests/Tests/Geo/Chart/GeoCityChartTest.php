<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Tests\Geo\Chart;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\Geo\Chart\GeoCityChart;
use Dms\Common\Structure\Geo\Chart\GeoCountryChart;
use Dms\Common\Structure\Geo\Country;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Table\Chart\Structure\ChartAxis;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class GeoCityChartTest extends CmsTestCase
{
    public function testNew()
    {
        $chart = new GeoCityChart(
            $city = ChartAxis::forField(Field::create('city', 'City')->string()->required()->build()),
            $amount = ChartAxis::forField(Field::create('amount', 'Amount')->int()->build()),
            $country = new Country(Country::AU)
        );

        $this->assertSame(['city' => $city, 'amount' => $amount], $chart->getAxes());
        $this->assertSame(true, $chart->hasAxis('city'));
        $this->assertSame(true, $chart->hasAxis('amount'));;
        $this->assertSame(false, $chart->hasAxis('other'));
        $this->assertSame($city, $chart->getAxis('city'));
        $this->assertSame($amount, $chart->getAxis('amount'));
        $this->assertSame($city, $chart->getLocationAxis());
        $this->assertSame($amount, $chart->getValueAxis());
        $this->assertSame($country, $chart->getMapCountry());

        $this->assertThrows(function () use ($chart) {
            $chart->getAxis('other');
        }, InvalidArgumentException::class);
    }

    public function testInvalidCityAxis()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new GeoCountryChart(
            $country = ChartAxis::forField(Field::create('address', 'Address')->streetAddress()->build()),
            $amount = ChartAxis::forField(Field::create('amount', 'Amount')->int()->build())
        );
    }
}