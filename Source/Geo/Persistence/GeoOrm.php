<?php

namespace Iddigital\Cms\Common\Structure\Geo\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\DateTimeRange;
use Iddigital\Cms\Common\Structure\DateTime\TimeRange;
use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTime;
use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Common\Structure\Geo\StringAddressWithLatLng;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Orm;

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
                StringAddress::class           => StringAddressMapper::class,
                StringAddressWithLatLng::class => StringAddressWithLatLngMapper::class,
        ]);
    }
}