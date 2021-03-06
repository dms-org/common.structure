<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\Image;
use Dms\Common\Structure\FileSystem\RelativePathCalculator;

/**
 * The image value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageMapper extends FileOrDirectoryMapper
{
    /**
     * ImageMapper constructor.
     *
     * @param string                      $filePathColumnName
     * @param string|null                 $clientFileNameColumnName
     * @param string|null                 $baseDirectoryPath
     * @param RelativePathCalculator|null $relativePathCalculator
     */
    public function __construct(
            string $filePathColumnName = 'image',
            string $clientFileNameColumnName = null,
            string $baseDirectoryPath = null,
            RelativePathCalculator $relativePathCalculator = null
    ) {
        parent::__construct($filePathColumnName, $clientFileNameColumnName, $baseDirectoryPath, $relativePathCalculator);
    }

    /**
     * @return string
     */
    protected function classType() : string
    {
        return Image::class;
    }

    /**
     * @return string
     */
    protected function fullPathPropertyName() : string
    {
        return Image::FULL_PATH;
    }

    /**
     * @return string|null
     */
    protected function clientFileNamePropertyName()
    {
        return Image::CLIENT_FILE_NAME;
    }
}