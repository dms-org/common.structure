<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\PathHelper;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class PathHelperTest extends CmsTestCase
{
    public function testNormalize()
    {
        $this->assertSame('.' . DIRECTORY_SEPARATOR . 'a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::normalize('./a/b/c'));
        $this->assertSame(DIRECTORY_SEPARATOR . 'a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::normalize('/a/b/c'));
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::normalize('a/b/c'));
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::normalize('a//b/c'));
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::normalize('a////b////c'));
        $this->assertSame('data://aaaaa//\\bbbb', PathHelper::normalize('data://aaaaa//\\bbbb'));
        $this->assertSame('s3://a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::normalize('s3://a///b////\\c'));
    }

    public function testCombine()
    {
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::combine('a', 'b', 'c'));
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'c', PathHelper::combine('a', './', 'c'));
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'c', PathHelper::combine('a', './//', 'c'));
        $this->assertSame('a' . DIRECTORY_SEPARATOR . 'c', PathHelper::combine('a', '.\\', 'c'));
        $this->assertSame('s3://a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', PathHelper::combine('s3://', 'a', 'b', 'c'));
    }
}