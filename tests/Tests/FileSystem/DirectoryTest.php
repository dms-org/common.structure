<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\PathHelper;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DirectoryTest extends CmsTestCase
{
    public function testNew()
    {
        $dir = new Directory(__DIR__);

        $this->assertSame(PathHelper::normalize(__DIR__) . DIRECTORY_SEPARATOR, $dir->getFullPath());
        $this->assertSame(basename(__DIR__), $dir->getName());
        $this->assertSame(__DIR__, $dir->getInfo()->getRealPath());
        $this->assertSame(true, $dir->exists());
    }

    public function testNonExistent()
    {
        $dir = new Directory(__DIR__ . '/abc');

        $this->assertSame(PathHelper::combine(__DIR__, 'abc/'), $dir->getFullPath());
        $this->assertSame('abc', $dir->getName());
        $this->assertSame(false, $dir->exists());
    }
}