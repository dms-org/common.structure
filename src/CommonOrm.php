<?php

namespace Dms\Common\Structure;

use Dms\Common\Structure\Colour\Mapper\ColourOrm;
use Dms\Common\Structure\DateTime\Persistence\DateTimeOrm;
use Dms\Common\Structure\FileSystem\Persistence\FileSystemOrm;
use Dms\Common\Structure\Geo\Persistence\GeoOrm;
use Dms\Common\Structure\Web\Persistence\WebOrm;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;

/**
 * The orm containing all the common mappers.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class CommonOrm extends Orm
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
        $orm->encompassAll([
                new ColourOrm(),
                new DateTimeOrm(),
                new GeoOrm(),
                new FileSystemOrm(),
                new WebOrm(),
        ]);
    }
}