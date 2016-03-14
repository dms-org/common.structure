<?php

namespace Dms\Common\Structure\Geo\Chart;

use Dms\Common\Structure\Geo\Country;
use Dms\Common\Structure\Geo\LatLng;
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
     * @var IChartAxis|null
     */
    private $cityLatLngAxis;

    /**
     * @inheritDoc
     */
    public function __construct(IChartAxis $cityAxis, IChartAxis $cityLatLngAxis = null, IChartAxis $valueAxis, Country $mapCountry = null)
    {
        $cityAxisType = $cityAxis->getComponent()->getType()->getPhpType();

        InvalidArgumentException::verify(
            $cityAxisType->equals(Type::string()),
            'The city axis \'%s\' is incompatible: expecting type %s, %s given',
            $cityAxis->getName(), 'string', $cityAxisType->asTypeString()
        );

        if ($cityLatLngAxis) {
            $cityLatLngAxisType = $cityLatLngAxis->getComponent()->getType()->getPhpType();

            InvalidArgumentException::verify(
                $cityLatLngAxisType->equals(LatLng::type()),
                'The city lat/lng axis \'%s\' is incompatible: expecting type %s, %s given',
                $cityLatLngAxis->getName(), LatLng::class, $cityLatLngAxisType->asTypeString()
            );
        }

        parent::__construct($cityAxis, $valueAxis, $cityLatLngAxis ? [$cityLatLngAxis] : []);
        $this->mapCountry     = $mapCountry;
        $this->cityLatLngAxis = $cityLatLngAxis;
    }

    /**
     * @return bool
     */
    public function hasMapCountry() : bool
    {
        return $this->mapCountry !== null;
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

    /**
     * @return bool
     */
    public function hasCityLatLngAxis() : bool
    {
        return $this->cityLatLngAxis !== null;
    }

    /**
     * @return IChartAxis|null
     */
    public function getCityLatLngAxis()
    {
        return $this->cityLatLngAxis;
    }
}