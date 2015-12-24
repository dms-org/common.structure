<?php

namespace Dms\Common\Structure\Geo\Persistence;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The lat/lng value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LatLngMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $latColumnName;

    /**
     * @var string
     */
    protected $lngColumnName;

    /**
     * LatLngMapper constructor.
     *
     * @param string $latColumnName
     * @param string $lngColumnName
     */
    public function __construct($latColumnName = 'lat', $lngColumnName = 'lng')
    {
        $this->latColumnName = $latColumnName;
        $this->lngColumnName = $lngColumnName;
        parent::__construct();
    }


    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(LatLng::class);

        // 8 decimal places should be plenty accurate as per
        // @see https://en.wikipedia.org/wiki/Decimal_degrees#Precision

        // Lat: 2 figures as within -90 to 90
        $map->property(LatLng::LAT)->to($this->latColumnName)->asDecimal(10, 8);

        // Lng: 3 figures as within -180 to 180
        $map->property(LatLng::LNG)->to($this->lngColumnName)->asDecimal(11, 8);
    }
}