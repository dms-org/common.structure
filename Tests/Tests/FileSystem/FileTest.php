<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidOperationException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileTest extends CmsTestCase
{
    public function testNew()
    {
        $file = new File(__FILE__);

        $this->assertSame(str_replace('\\', '/', __FILE__), $file->getFullPath());
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

        $this->assertSame(str_replace('\\', '/', __DIR__) . '/non-existent.php', $file->getFullPath());
        $this->assertSame('non-existent.php', $file->getName());
        $this->assertSame(false, $file->exists());
        $this->assertSame('php', $file->getExtension());
        $this->assertEquals(new Directory(__DIR__), $file->getDirectory());

        $this->assertThrows(function () use ($file) {
            $file->getSize();
        }, InvalidOperationException::class);
    }
}