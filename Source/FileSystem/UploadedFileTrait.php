<?php

namespace Iddigital\Cms\Common\Structure\FileSystem;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Exception\InvalidOperationException;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;

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
    protected $clientFileName;

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
        $class->property($this->clientFileName)->nullable()->asString();
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
    public function getClientFileName()
    {
        return $this->clientFileName;
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

        return new File($fullPath);
    }
}