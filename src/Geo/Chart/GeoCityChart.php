<?php

namespace Dms\Common\Structure\Geo\Chart;

use Dms\Common\Structure\Geo\Country;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Core\Table\Chart\IChartAxis;

/**
 * The geo-map city chart class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class GeoCityChart extends GeoChart
{
    /**
     * @var Country
     */
    private $mapCountry;

    /**
     * @inheritDoc
     */
    public function __construct(IChartAxis $cityAxis, IChartAxis $valueAxis, Country $mapCountry = null)
    {
        $cityAxisType = $cityAxis->getComponent()->getType()->getPhpType();

        InvalidArgumentException::verify(
            $cityAxisType->equals(Type::string()),
            'The city axis \'%s\' is incompatible: expecting type %s, %s given',
            $cityAxis->getName(), 'string', $cityAxisType->asTypeString()
        );

        parent::__construct($cityAxis, $valueAxis);
        $this->mapCountry = $mapCountry;
    }

    /**
     * Gets the country to display the map of or NULL if
     * to display a world map.
     *
     * @return Country|null
     */
    public function getMapCountry()
    {
        return $this->mapCountry;
    }
}