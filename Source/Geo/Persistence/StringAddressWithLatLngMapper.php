<?php

namespace Iddigital\Cms\Common\Structure\Geo\Persistence;

use Iddigital\Cms\Common\Structure\Geo\StringAddressWithLatLng;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The string address with lat/lng value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressWithLatLngMapper extends StringAddressMapper
{
    /**
     * @var string
     */
    protected $addressColumnName;

    /**
     * @var string
     */
    protected $latColumnName;

    /**
     * @var string
     */
    protected $lngColumnName;

    /**
     * StringAddressMapper constructor.
     *
     * @param string $addressColumnName
     * @param string $latColumnName
     * @param string $lngColumnName
     */
    public function __construct($addressColumnName = 'address', $latColumnName = 'lat', $lngColumnName = 'lng')
    {
        $this->addressColumnName = $addressColumnName;
        $this->latColumnName     = $latColumnName;
        $this->lngColumnName     = $lngColumnName;
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
        parent::define($map);

        $map->type(StringAddressWithLatLng::class);

        $map->embedded(StringAddressWithLatLng::LAT_LNG)
                ->using(new LatLngMapper($this->latColumnName, $this->lngColumnName));
    }
}