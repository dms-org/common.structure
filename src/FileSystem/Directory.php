<?php declare(strict_types = 1);

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
    protected function normalizePath(string $fullPath) : string
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
    public function getName() : string
    {
        return $this->getInfo()->getFilename();
    }

    /**
     * Gets the full directory path.
     *
     * @return string
     */
    public function getFullPath() : string
    {
        return $this->fullPath;
    }

    /**
     * Gets whether the directory exists.
     *
     * @return bool
     */
    public function exists() : bool
    {
        return $this->getInfo()->isDir();
    }
}