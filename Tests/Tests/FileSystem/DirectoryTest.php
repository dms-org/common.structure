<?php

namespace Iddigital\Cms\Common\Structure\Tests\FileSystem;

use Iddigital\Cms\Common\Structure\FileSystem\Directory;
use Iddigital\Cms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DirectoryTest extends CmsTestCase
{
    public function testNew()
    {
        $dir = new Directory(__DIR__);

        $this->assertSame(str_replace('\\', '/', __DIR__) . '/', $dir->getFullPath());
        $this->assertSame(basename(__DIR__), $dir->getName());
        $this->assertSame(__DIR__, $dir->getInfo()->getRealPath());
        $this->assertSame(true, $dir->exists());
    }

    public function testNonExistent()
    {
        $dir = new Directory(__DIR__ . '/abc');

        $this->assertSame(str_replace('\\', '/', __DIR__) . '/abc/', $dir->getFullPath());
        $this->assertSame('abc', $dir->getName());
        $this->assertSame(false, $dir->exists());
    }
}