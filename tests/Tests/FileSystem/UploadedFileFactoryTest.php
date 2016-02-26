<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\PathHelper;
use Dms\Common\Structure\FileSystem\UploadedFile;
use Dms\Common\Structure\FileSystem\UploadedFileFactory;
use Dms\Common\Structure\FileSystem\UploadedImage;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UploadedFileFactoryTest extends CmsTestCase
{
    public function testFile()
    {
        $file = UploadedFileFactory::build(
                'abc/abc.txt',
                UPLOAD_ERR_OK,
                'abc.txt',
                'text/html'
        );

        $this->assertInstanceOf(UploadedFile::class, $file);
        $this->assertNotInstanceOf(UploadedImage::class, $file);
        $this->assertSame(PathHelper::normalize('abc/abc.txt'), $file->getFullPath());
        $this->assertSame(UPLOAD_ERR_OK, $file->getUploadError());
        $this->assertSame('abc.txt', $file->getClientFileName());
        $this->assertSame('text/html', $file->getClientMimeType());
    }

    public function testImage()
    {
        $file = UploadedFileFactory::build(
                'abc/abc.png',
                UPLOAD_ERR_OK,
                'abc.png',
                'image/png'
        );

        $this->assertNotInstanceOf(UploadedFile::class, $file);
        $this->assertInstanceOf(UploadedImage::class, $file);
        $this->assertSame(PathHelper::normalize('abc/abc.png'), $file->getFullPath());
        $this->assertSame(UPLOAD_ERR_OK, $file->getUploadError());
        $this->assertSame('abc.png', $file->getClientFileName());
        $this->assertSame('image/png', $file->getClientMimeType());
    }
}