<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Model\Object\ClassDefinition;

/**
 * The in-memory file value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class InMemoryFile extends File
{
    /**
     * @var int
     */
    protected $size;

    /**
     * File constructor.
     *
     * @param string      $data
     * @param string|null $clientFileName
     */
    public function __construct(string $data, string $clientFileName)
    {
        $path = 'data://text/plain;base64,' . base64_encode($data);

        parent::__construct($path, $clientFileName);

        $this->size = strlen($data);
    }

    /**
     * @inheritDoc
     */
    protected function define(ClassDefinition $class)
    {
        parent::define($class);

        $class->property($this->size)->asInt();
    }

    /**
     * @inheritDoc
     */
    protected function normalizePath(string $fullPath) : string
    {
        return PathHelper::normalize($fullPath);
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return $this->getClientFileName();
    }

    /**
     * @inheritDoc
     */
    public function getExtension() : string
    {
        $name = $this->getClientFileName();

        return strpos($name, '.') === false ? '' : substr($name, strrpos($name, '.') + 1);
    }

    /**
     * @inheritDoc
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function exists() : bool
    {
        return true;
    }
}