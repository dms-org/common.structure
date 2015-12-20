<?php

namespace Dms\Common\Structure\Geo\Persistence;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Common\Structure\Geo\StreetAddressWithLatLng;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;

/**
 * The geography value object orm.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class GeoOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->valueObjects([
                LatLng::class                  => LatLngMapper::class,
                StreetAddress::class           => StreetAddressMapper::class,
                StreetAddressWithLatLng::class => StreetAddressWithLatLngMapper::class,
        ]);
    }
}