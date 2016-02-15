<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\File\IImage;
use Dms\Core\Model\Object\ClassDefinition;

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
     * Image constructor.
     *
     * @param string      $fullPath
     * @param string|null $clientFileName
     */
    public function __construct(string $fullPath, string $clientFileName = null)
    {
        parent::__construct($fullPath, $clientFileName);
    }

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
    protected function loadImageInfo() : bool
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
    public function isValidImage() : bool
    {
        return $this->loadImageInfo();
    }

    /**
     * Gets the image width in pixels.
     *
     * @return int
     * @throws InvalidOperationException
     */
    public function getWidth() : int
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
    public function getHeight() : int
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