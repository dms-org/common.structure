<?php declare(strict_types = 1);

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
     * @param bool                        $allowInMemoryFiles
     */
    public function __construct(
        string $filePathColumnName = 'file',
        string $clientFileNameColumnName = null,
        string $baseDirectoryPath = null,
        RelativePathCalculator $relativePathCalculator = null,
        bool $allowInMemoryFiles = false
    ) {
        parent::__construct($filePathColumnName, $clientFileNameColumnName, $baseDirectoryPath, $relativePathCalculator, $allowInMemoryFiles);
    }

    /**
     * @return string
     */
    protected function classType() : string
    {
        return File::class;
    }

    /**
     * @return string
     */
    protected function fullPathPropertyName() : string
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