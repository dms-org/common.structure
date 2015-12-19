<?php

namespace Iddigital\Cms\Common\Structure\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\Directory;
use Iddigital\Cms\Common\Structure\FileSystem\File;
use Iddigital\Cms\Common\Structure\FileSystem\Image;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Orm;

/**
 * The file system orm.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileSystemOrm extends Orm
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
                Directory::class => DirectoryMapper::class,
                File::class      => FileMapper::class,
                Image::class     => ImageMapper::class,
        ]);
    }
}