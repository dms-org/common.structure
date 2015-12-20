<?php

namespace Dms\Common\Structure\Tests\ImageSystem;

use Dms\Common\Structure\FileSystem\UploadedImage;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UploadedImageTest extends CmsTestCase
{
    public function testSuccess()
    {
        $image = new UploadedImage(__DIR__ . '/Fixtures/picture.png', UPLOAD_ERR_OK, 'client-image-name', 'client/mime');

        $this->assertSame(true, $image->hasUploadedSuccessfully());
        $this->assertSame(UPLOAD_ERR_OK, $image->getUploadError());
        $this->assertSame('client-image-name', $image->getClientFileName());
        $this->assertSame('client/mime', $image->getClientMimeType());
    }

    public function testError()
    {
        $image = new UploadedImage(__FILE__, UPLOAD_ERR_INI_SIZE);

        $this->assertSame(false, $image->hasUploadedSuccessfully());
        $this->assertSame(UPLOAD_ERR_INI_SIZE, $image->getUploadError());
        $this->assertSame(null, $image->getClientFileName());
        $this->assertSame(null, $image->getClientMimeType());
    }
}