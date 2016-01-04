<?php

namespace Dms\Common\Structure\Colour\Mapper;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ColourOrm extends Orm
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
                Colour::class            => ColourMapper::class,
                TransparentColour::class => TransparentColourMapper::class,
        ]);
    }
}