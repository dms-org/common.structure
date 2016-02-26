<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

/**
 * The file system object value class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class FileSystemObject extends ValueObject
{
    const FULL_PATH = 'fullPath';

    /**
     * @var string
     */
    protected $fullPath;

    /**
     * @var \SplFileInfo|null
     */
    protected $info;

    /**
     * FileSystemObject constructor.
     *
     * @param string $fullPath
     */
    public function __construct(string $fullPath)
    {
        parent::__construct();
        $this->fullPath = $this->normalizePath($fullPath);
    }

    /**
     * @param string $fullPath
     *
     * @return string
     */
    abstract protected function normalizePath(string $fullPath) : string;

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->fullPath)->asString();

        $class->property($this->info)->nullable()->asObject(\SplFileInfo::class);
    }

    /**
     * Gets the file name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->getInfo()->getFilename();
    }

    /**
     * Get the info
     *
     * @return \SplFileInfo
     */
    public function getInfo()
    {
        if ($this->info === null) {
            $this->info = new \SplFileInfo($this->fullPath);
        }

        return $this->info;
    }
}