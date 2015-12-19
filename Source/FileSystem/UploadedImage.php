<?php

namespace Iddigital\Cms\Common\Structure\FileSystem;

use Iddigital\Cms\Core\File\IUploadedImage;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;

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
    public function __construct($fullPath, $uploadStatus, $clientFileName = null, $clientMimeType = null)
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