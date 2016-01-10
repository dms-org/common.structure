<?php

namespace Dms\Common\Structure\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\RelativePathCalculator;

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
     * @param string                      $filePathColumnName
     * @param string|null                 $clientFileNameColumnName
     * @param string|null                 $baseDirectoryPath
     * @param RelativePathCalculator|null $relativePathCalculator
     */
    public function __construct(
            $filePathColumnName = 'file',
            $clientFileNameColumnName = null,
            $baseDirectoryPath = null,
            RelativePathCalculator $relativePathCalculator = null
    ) {
        parent::__construct($filePathColumnName, $clientFileNameColumnName, $baseDirectoryPath, $relativePathCalculator);
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

    /**
     * @return string|null
     */
    protected function clientFileNamePropertyName()
    {
        return File::CLIENT_FILE_NAME;
    }
}