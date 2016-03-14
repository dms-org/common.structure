<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\InMemoryFile;
use Dms\Common\Structure\FileSystem\PathHelper;
use Dms\Common\Structure\FileSystem\UploadedFile;
use Dms\Common\Structure\FileSystem\UploadedImage;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\File\IFile;
use Dms\Core\File\IUploadedFile;
use Dms\Core\File\IUploadedImage;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileTest extends CmsTestCase
{
    public function testNew()
    {
        $file = new File(__FILE__);

        $this->assertSame(PathHelper::normalize(__FILE__), $file->getFullPath());
        $this->assertSame(basename(__FILE__), $file->getName());
        $this->assertSame(__FILE__, $file->getInfo()->getRealPath());
        $this->assertSame(true, $file->exists());
        $this->assertSame('php', $file->getExtension());
        $this->assertEquals(new Directory(__DIR__), $file->getDirectory());
        $this->assertSame(filesize(__FILE__), $file->getSize());
    }

    public function testNonExistent()
    {
        $file = new File(__DIR__ . '/non-existent.php');

        $this->assertSame(PathHelper::combine(PathHelper::normalize(__DIR__), 'non-existent.php'), $file->getFullPath());
        $this->assertSame('non-existent.php', $file->getName());
        $this->assertSame(false, $file->exists());
        $this->assertSame('php', $file->getExtension());
        $this->assertEquals(new Directory(__DIR__), $file->getDirectory());

        $this->assertThrows(function () use ($file) {
            $file->getSize();
        }, InvalidOperationException::class);
    }

    public function testFromExisting()
    {
        $mockFile = $this->getMockForAbstractClass(IFile::class);
        $mockFile->method('getFullPath')
                ->willReturn(__FILE__);
        $mockFile->method('getClientFileName')
                ->willReturn('abc');

        $mockUploadedFile = $this->getMockForAbstractClass(IUploadedFile::class);
        $mockUploadedFile->method('getFullPath')
                ->willReturn(__FILE__);
        $mockUploadedFile->method('getUploadError')
                ->willReturn(UPLOAD_ERR_OK);
        $mockUploadedFile->method('getClientFileName')
                ->willReturn('abc');

        $mockUploadedImage = $this->getMockForAbstractClass(IUploadedImage::class);
        $mockUploadedImage->method('getFullPath')
                ->willReturn(__FILE__);
        $mockUploadedImage->method('getUploadError')
                ->willReturn(UPLOAD_ERR_NO_TMP_DIR);
        $mockUploadedImage->method('getClientFileName')
                ->willReturn('abc');

        $file = new File(__FILE__, 'abc');

        $this->assertSame($file, File::fromExisting($file));
        $this->assertEquals($file, File::fromExisting($mockFile));
        $this->assertEquals(new UploadedFile(__FILE__, UPLOAD_ERR_OK, 'abc'), File::fromExisting($mockUploadedFile));
        $this->assertEquals(new UploadedImage(__FILE__, UPLOAD_ERR_NO_TMP_DIR, 'abc'), File::fromExisting($mockUploadedImage));
    }

    public function testInMemory()
    {
        $file = new InMemoryFile('some-string', 'name.txt');

        $this->assertStringStartsWith('data://text/plain', $file->getFullPath());
        $this->assertSame('some-string', file_get_contents($file->getFullPath()));
        $this->assertSame('name.txt', $file->getClientFileName());
        $this->assertSame('name.txt', $file->getName());
        $this->assertSame('txt', $file->getExtension());
        $this->assertSame(true, $file->exists());
        $this->assertSame(strlen('some-string'), $file->getSize());
    }

    public function testCreateTemporary()
    {
        $file = File::createTemporary('some-string', 'name.txt');

        $this->assertStringStartsWith(PathHelper::normalize(sys_get_temp_dir()), $file->getFullPath());
        $this->assertStringStartsWith('dms', $file->getName());
        $this->assertSame('some-string', file_get_contents($file->getFullPath()));
    }
}