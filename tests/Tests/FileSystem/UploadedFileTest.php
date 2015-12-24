<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\UploadedFile;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidOperationException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UploadedFileTest extends CmsTestCase
{
    public function testSuccess()
    {
        $file = new UploadedFile(__FILE__, UPLOAD_ERR_OK, 'client-file-name', 'client/mime');

        $this->assertSame(true, $file->hasUploadedSuccessfully());
        $this->assertSame(UPLOAD_ERR_OK, $file->getUploadError());
        $this->assertSame('client-file-name', $file->getClientFileName());
        $this->assertSame('client/mime', $file->getClientMimeType());
    }

    public function testError()
    {
        $file = new UploadedFile(__FILE__, UPLOAD_ERR_NO_FILE);

        $this->assertSame(false, $file->hasUploadedSuccessfully());
        $this->assertSame(UPLOAD_ERR_NO_FILE, $file->getUploadError());
        $this->assertSame(null, $file->getClientFileName());
        $this->assertSame(null, $file->getClientMimeType());
    }
}