<?php

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

/**
 * The directory value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Directory extends FileSystemObject
{
    /**
     * @inheritDoc
     */
    protected function normalizePath($fullPath)
    {
        $fullPath = str_replace('\\', '/', $fullPath);

        if (substr($fullPath, -1) !== '/') {
            $fullPath .= '/';
        }

        return $fullPath;
    }


    /**
     * Gets the directory name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getInfo()->getFilename();
    }

    /**
     * Gets the full directory path.
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * Gets whether the directory exists.
     *
     * @return bool
     */
    public function exists()
    {
        return $this->getInfo()->isDir();
    }
}