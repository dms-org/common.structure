<?php

namespace Iddigital\Cms\Common\Structure\FileSystem;

use Iddigital\Cms\Core\Exception\InvalidOperationException;
use Iddigital\Cms\Core\File\IImage;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;

/**
 * The image value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Image extends File implements IImage
{
    /**
     * @var int|null
     */
    protected $width;

    /**
     * @var int|null
     */
    protected $height;

    /**
     * @inheritDoc
     */
    protected function define(ClassDefinition $class)
    {
        parent::define($class);

        $class->property($this->width)->nullable()->asInt();

        $class->property($this->height)->nullable()->asInt();
    }

    /**
     * @return bool
     */
    protected function loadImageInfo()
    {
        if (is_int($this->height) && is_int($this->width)) {
            return true;
        }

        if (!$this->exists()) {
            return false;
        }

        $imageInfo = getimagesize($this->fullPath);

        if (!$imageInfo) {
            return false;
        }

        list($this->width, $this->height) = $imageInfo;

        return true;
    }

    /**
     * Returns whether the file is a valid image
     *
     * @return bool
     */
    public function isValidImage()
    {
        return $this->loadImageInfo();
    }

    /**
     * Gets the image width in pixels.
     *
     * @return int
     * @throws InvalidOperationException
     */
    public function getWidth()
    {
        if (!$this->loadImageInfo()) {
            throw InvalidOperationException::format(
                    'Invalid call to %s: file \'%s\' is not a valid image',
                    __METHOD__,
                    $this->fullPath
            );
        }

        return $this->width;
    }

    /**
     * Gets the image height in pixels.
     *
     * @return int
     * @throws InvalidOperationException
     */
    public function getHeight()
    {
        if (!$this->loadImageInfo()) {
            throw InvalidOperationException::format(
                    'Invalid call to %s: file \'%s\' is not a valid image',
                    __METHOD__,
                    $this->fullPath
            );
        }

        return $this->height;
    }
}