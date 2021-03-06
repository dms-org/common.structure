<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Tests\Geo\Chart;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\Geo\Chart\GeoChart;
use Dms\Common\Structure\Geo\Chart\GeoCountryChart;
use Dms\Common\Structure\Geo\Country;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Table\Chart\Structure\ChartAxis;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class GeoCountryChartTest extends CmsTestCase
{
    public function testNew()
    {
        $chart = new GeoCountryChart(
            $country = ChartAxis::forField(Field::create('country', 'Country')->enum(Country::class, Country::getNameMap())->required()->build()),
            $amount = ChartAxis::forField(Field::create('amount', 'Amount')->int()->build())
        );

        $this->assertSame(['country' => $country, 'amount' => $amount], $chart->getAxes());
        $this->assertSame(true, $chart->hasAxis('country'));
        $this->assertSame(true, $chart->hasAxis('amount'));;
        $this->assertSame(false, $chart->hasAxis('other'));
        $this->assertSame($country, $chart->getAxis('country'));
        $this->assertSame($amount, $chart->getAxis('amount'));
        $this->assertSame($country, $chart->getLocationAxis());
        $this->assertSame($amount, $chart->getValueAxis());

        $this->assertThrows(function () use ($chart) {
            $chart->getAxis('other');
        }, InvalidArgumentException::class);
    }

    public function testInvalidCountryAxis()
    {
        $this->expectException(InvalidArgumentException::class);

        new GeoCountryChart(
            $country = ChartAxis::forField(Field::create('address', 'Address')->string()->build()),
            $amount = ChartAxis::forField(Field::create('amount', 'Amount')->int()->build())
        );
    }
}