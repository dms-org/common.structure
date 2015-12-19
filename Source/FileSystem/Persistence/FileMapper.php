<?php

namespace Iddigital\Cms\Common\Structure\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\File;

/**
 * The file value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileMapper extends FileOrDirectoryMapper
{
    /**
     * FileMapper constructor.
     *
     * @param string      $filePathColumnName
     * @param string|null $baseDirectoryPath
     */
    public function __construct($filePathColumnName, $baseDirectoryPath = null)
    {
        parent::__construct($filePathColumnName, $baseDirectoryPath);
    }

    /**
     * @return string
     */
    protected function classType()
    {
        return File::class;
    }

    /**
     * @return string
     */
    protected function fullPathPropertyName()
    {
        return File::FULL_PATH;
    }
}