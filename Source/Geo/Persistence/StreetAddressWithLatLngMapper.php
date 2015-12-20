<?php

namespace Dms\Common\Structure\Geo\Persistence;

use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Common\Structure\Geo\StreetAddressWithLatLng;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The string address with lat/lng value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressWithLatLngMapper extends IndependentValueObjectMapper
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
        $map->type(StreetAddressWithLatLng::class);

        $map->property(StreetAddressWithLatLng::ADDRESS)
                ->to($this->addressColumnName)->asVarchar(StreetAddress::MAX_LENGTH);

        $map->embedded(StreetAddressWithLatLng::LAT_LNG)
                ->using(new LatLngMapper($this->latColumnName, $this->lngColumnName));
    }
}