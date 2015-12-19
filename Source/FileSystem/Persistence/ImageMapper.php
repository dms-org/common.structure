<?php

namespace Iddigital\Cms\Common\Structure\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\Image;

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
     * @param string      $filePathColumnName
     * @param string|null $baseDirectoryPath
     */
    public function __construct($filePathColumnName = 'image', $baseDirectoryPath = null)
    {
        parent::__construct($filePathColumnName, $baseDirectoryPath);
    }

    /**
     * @return string
     */
    protected function classType()
    {
        return Image::class;
    }

    /**
     * @return string
     */
    protected function fullPathPropertyName()
    {
        return Image::FULL_PATH;
    }
}