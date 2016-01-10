<?php

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\File\IFile;
use Dms\Core\File\IImage;
use Dms\Core\File\IUploadedFile;
use Dms\Core\File\IUploadedImage;

/**
 * The file value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class File extends FileSystemObject implements IFile
{
    /**
     * @param IFile $file
     *
     * @return File
     */
    public static function fromExisting(IFile $file)
    {
        if ($file instanceof self) {
            return $file;
        } elseif ($file instanceof IUploadedImage) {
            return new UploadedImage($file->getFullPath(), $file->getUploadError());
        } elseif ($file instanceof IUploadedFile) {
            return new UploadedFile($file->getFullPath(), $file->getUploadError());
        } elseif ($file instanceof IImage) {
            return new Image($file->getFullPath());
        } else {
            return new self($file->getFullPath());
        }
    }

    /**
     * @inheritDoc
     */
    protected function normalizePath($fullPath)
    {
        return str_replace('\\', '/', $fullPath);
    }

    /**
     * Gets the file name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getInfo()->getFilename();
    }

    /**
     * Gets the directory containing the file.
     *
     * @return Directory
     */
    public function getDirectory()
    {
        return new Directory($this->getInfo()->getPath());
    }

    /**
     * Gets the file extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->getInfo()->getExtension();
    }

    /**
     * Gets the full file path including the file name.
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * Gets the file size in bytes.
     *
     * @return int
     * @throws InvalidOperationException
     */
    public function getSize()
    {
        if (!$this->exists()) {
            throw InvalidOperationException::format(
                    'Invalid call to %s: file \'%s\' does not exist',
                    __METHOD__,
                    $this->fullPath
            );
        }

        return $this->getInfo()->getSize();
    }

    /**
     * Gets whether the file exists.
     *
     * @return bool
     */
    public function exists()
    {
        return $this->getInfo()->isFile();
    }
}