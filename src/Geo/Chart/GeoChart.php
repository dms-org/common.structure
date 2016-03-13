<?php

namespace Dms\Common\Structure\Geo\Chart;

use Dms\Common\Structure\Geo\Country;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Table\Chart\IChartAxis;
use Dms\Core\Table\Chart\Structure\PieChart;

/**
 * The geo-map chart class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class GeoChart extends PieChart
{
    /**
     * @inheritDoc
     */
    public function __construct(IChartAxis $countryAxis, IChartAxis $valueAxis)
    {
        parent::__construct($countryAxis, $valueAxis);

        $countryAxisType = $countryAxis->getComponent()->getType()->getPhpType();

        InvalidArgumentException::verify(
            $countryAxisType->equals(Country::type()),
            'The country axis \'%s\' is incompatible: expecting type %s, %s given',
            $countryAxis->getName(), Country::class, $countryAxisType->asTypeString()
        );
    }
}