<?php

namespace Dms\Common\Structure\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\RelativePathCalculator;

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
     * @param string                      $directoryPathColumnName
     * @param string|null                 $baseDirectoryPath
     * @param RelativePathCalculator|null $relativePathCalculator
     */
    public function __construct(
            $directoryPathColumnName = 'directory',
            $baseDirectoryPath = null,
            RelativePathCalculator $relativePathCalculator = null
    ) {
        parent::__construct($directoryPathColumnName, null, $baseDirectoryPath, $relativePathCalculator);
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

    /**
     * @return string|null
     */
    protected function clientFileNamePropertyName()
    {
        return null;
    }
}