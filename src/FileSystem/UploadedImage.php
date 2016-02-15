<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\File\IUploadedImage;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * The uploaded file value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UploadedImage extends Image implements IUploadedImage
{
    use UploadedFileTrait;

    /**
     * UploadedFile constructor.
     *
     * @param string      $fullPath
     * @param int         $uploadStatus
     * @param string|null $clientFileName
     * @param string|null $clientMimeType
     */
    public function __construct(string $fullPath, int $uploadStatus, string $clientFileName = null, string $clientMimeType = null)
    {
        parent::__construct($fullPath);

        $this->uploadStatus   = $uploadStatus;
        $this->clientFileName = $clientFileName;
        $this->clientMimeType = $clientMimeType;

        $this->verifyUploadStatus($uploadStatus);
    }

    /**
     * @inheritDoc
     */
    protected function define(ClassDefinition $class)
    {
        parent::define($class);

        $this->defineUploadedFileTrait($class);
    }
}