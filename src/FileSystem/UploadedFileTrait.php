<?php

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
    public function verifyUploadStatus($uploadStatus)
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
    public function hasUploadedSuccessfully()
    {
        return $this->uploadStatus === UPLOAD_ERR_OK;
    }

    /**
     * @inheritdoc
     */
    public function getUploadError()
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
    public function moveTo($fullPath)
    {
        if (!$this->hasUploadedSuccessfully()) {
            throw InvalidOperationException::format(
                    'Invalid call to %s: file upload was not successful with \'%s\' error code',
                    __METHOD__, $this->uploadStatus
            );
        }

        if (!move_uploaded_file($this->fullPath, $fullPath)) {
            throw CouldNotMoveUploadedFileException::format(
                    'An error occurred while moving the uploaded file \'%s\' to \'%s\'',
                    $this->fullPath, $fullPath
            );
        }

        if ($this instanceof IUploadedImage) {
            return new Image($fullPath, $this->getClientFileName());
        } else {
            /** @var IUploadedFile $this */
            return new File($fullPath, $this->getClientFileName());
        }
    }
}