<?php

namespace Iddigital\Cms\Common\Structure;

use Iddigital\Cms\Common\Structure\DateTime\Persistence\DateTimeOrm;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\FileSystemOrm;
use Iddigital\Cms\Common\Structure\Geo\Persistence\GeoOrm;
use Iddigital\Cms\Common\Structure\Web\Persistence\WebOrm;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Orm;

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
                new DateTimeOrm(),
                new GeoOrm(),
                new FileSystemOrm(),
                new WebOrm(),
        ]);
    }
}