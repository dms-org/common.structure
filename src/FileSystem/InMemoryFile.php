<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\File\IFile;
use Dms\Core\File\IImage;
use Dms\Core\File\IUploadedFile;
use Dms\Core\File\IUploadedImage;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * The in-memory file value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class InMemoryFile extends File
{
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
}