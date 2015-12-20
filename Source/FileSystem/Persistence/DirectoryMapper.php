<?php

namespace Dms\Common\Structure\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\Directory;

/**
 * The directory value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DirectoryMapper extends FileOrDirectoryMapper
{
    /**
     * DirectoryMapper constructor.
     *
     * @param string      $directoryPathColumnName
     * @param string|null $baseDirectoryPath
     */
    public function __construct($directoryPathColumnName = 'directory', $baseDirectoryPath = null)
    {
        parent::__construct($directoryPathColumnName, $baseDirectoryPath);
    }

    /**
     * @return string
     */
    protected function classType()
    {
        return Directory::class;
    }

    /**
     * @return string
     */
    protected function fullPathPropertyName()
    {
        return Directory::FULL_PATH;
    }
}