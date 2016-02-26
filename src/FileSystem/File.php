<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\File\IFile;
use Dms\Core\File\IImage;
use Dms\Core\File\IUploadedFile;
use Dms\Core\File\IUploadedImage;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * The file value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class File extends FileSystemObject implements IFile
{
    const CLIENT_FILE_NAME = 'clientFileName';

    /**
     * @var string|null
     */
    protected $clientFileName;

    /**
     * File constructor.
     *
     * @param string      $fullPath
     * @param string|null $clientFileName
     */
    public function __construct(string $fullPath, string $clientFileName = null)
    {
        parent::__construct($fullPath);
        $this->clientFileName = $clientFileName;
    }

    /**
     * @inheritDoc
     */
    protected function define(ClassDefinition $class)
    {
        parent::define($class);

        $class->property($this->clientFileName)->nullable()->asString();
    }

    /**
     * @param IFile $file
     *
     * @return File
     */
    public static function fromExisting(IFile $file) : File
    {
        if ($file instanceof self) {
            return $file;
        } elseif ($file instanceof IUploadedImage) {
            return new UploadedImage($file->getFullPath(), $file->getUploadError(), $file->getClientFileName(), $file->getClientMimeType());
        } elseif ($file instanceof IUploadedFile) {
            return new UploadedFile($file->getFullPath(), $file->getUploadError(), $file->getClientFileName(), $file->getClientMimeType());
        } elseif ($file instanceof IImage) {
            return new Image($file->getFullPath(), $file->getClientFileName());
        } else {
            return new self($file->getFullPath(), $file->getClientFileName());
        }
    }

    /**
     * @inheritDoc
     */
    protected function normalizePath(string $fullPath) : string
    {
        return str_replace('\\', '/', $fullPath);
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return $this->getInfo()->getFilename();
    }

    /**
     * @inheritDoc
     */
    public function getClientFileName()
    {
        return $this->clientFileName;
    }

    /**
     * @inheritDoc
     */
    public function getClientFileNameWithFallback() : string
    {
        return $this->clientFileName ?: $this->getName();
    }

    /**
     * @inheritDoc
     */
    public function getDirectory() : Directory
    {
        return new Directory($this->getInfo()->getPath());
    }

    /**
     * @inheritDoc
     */
    public function getExtension() : string
    {
        return $this->getInfo()->getExtension();
    }

    /**
     * @inheritDoc
     */
    public function getFullPath() : string
    {
        return $this->fullPath;
    }

    /**
     * @inheritDoc
     */
    public function getSize() : int
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
     * @inheritDoc
     */
    public function exists() : bool
    {
        return $this->getInfo()->isFile();
    }

    /**
     * @inheritdoc
     */
    public function moveTo(string $fullPath) : IFile
    {
        if (!$this->exists()) {
            throw InvalidOperationException::format(
                'Invalid call to %s: file does not exist',
                __METHOD__
            );
        }

        $dirName = dirname($fullPath);
        if (!@is_dir($dirName)) {
            @mkdir($dirName, 0777, true);
        }

        if (!rename($this->fullPath, $fullPath)) {
            throw CouldNotMoveFileException::format(
                'An error occurred while moving the file \'%s\' to \'%s\'',
                $this->fullPath, $fullPath
            );
        }

        if ($this instanceof IImage) {
            return new Image($fullPath, $this->getClientFileName());
        } else {
            /** @var IUploadedFile $this */
            return new File($fullPath, $this->getClientFileName());
        }
    }
}