<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\File\IFile;
use Dms\Core\File\IUploadedFile;
use Dms\Core\File\IUploadedImage;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * The uploaded file value object class.
 *
 * @property-read string $fullPath
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
trait UploadedFileTrait
{
    /**
     * @var int
     */
    protected $uploadStatus;

    /**
     * @var string|null
     */
    protected $clientMimeType;

    /**
     * @param int $uploadStatus
     *
     * @return void
     */
    public function verifyUploadStatus(int $uploadStatus)
    {
        InvalidArgumentException::verify(
                $uploadStatus >= 0 && $uploadStatus <= 8,
                'File upload status must be a valid UPLOAD_ERR_* value, \'%s\' given',
                $uploadStatus
        );
    }

    /**
     * @param ClassDefinition $class
     *
     * @return void
     */
    protected function defineUploadedFileTrait(ClassDefinition $class)
    {
        $class->property($this->uploadStatus)->asInt();
        $class->property($this->clientMimeType)->nullable()->asString();
    }

    /**
     * @inheritdoc
     */
    public function hasUploadedSuccessfully() : bool
    {
        return $this->uploadStatus === UPLOAD_ERR_OK;
    }

    /**
     * @inheritdoc
     */
    public function getUploadError() : int
    {
        return $this->uploadStatus;
    }

    /**
     * @inheritdoc
     */
    public function getClientMimeType()
    {
        return $this->clientMimeType;
    }

    /**
     * @inheritdoc
     */
    public function moveTo(string $fullPath) : IFile
    {
        if (!$this->hasUploadedSuccessfully()) {
            throw InvalidOperationException::format(
                    'Invalid call to %s: file upload was not successful with \'%s\' error code',
                    __METHOD__, $this->uploadStatus
            );
        }

        $fullPath = PathHelper::normalize($fullPath);
        $this->createDirectoryIfNotExists($fullPath);

        if (!move_uploaded_file($this->fullPath, $fullPath)) {
            throw CouldNotMoveUploadedFileException::format(
                    'An error occurred while moving the uploaded file \'%s\' to \'%s\'',
                    $this->fullPath, $fullPath
            );
        }

        return $this->buildNewFile($fullPath);
    }
    /**
     * @param string $fullPath
     *
     * @return void
     */
    abstract protected function createDirectoryIfNotExists(string $fullPath);

    /**
     * @param string $fullPath
     *
     * @return IFile
     */
    abstract protected function buildNewFile(string $fullPath) : IFile;
}