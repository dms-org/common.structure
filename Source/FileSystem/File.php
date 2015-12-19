<?php

namespace Iddigital\Cms\Common\Structure\FileSystem;

use Iddigital\Cms\Core\Exception\InvalidOperationException;
use Iddigital\Cms\Core\File\IFile;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\ValueObject;

/**
 * The file value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class File extends FileSystemObject implements IFile
{
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
     * Gets the full file path.
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