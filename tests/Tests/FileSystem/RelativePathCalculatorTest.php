<?php

namespace Dms\Common\Structure\Tests\FileSystem;

use Dms\Common\Structure\FileSystem\PathHelper;
use Dms\Common\Structure\FileSystem\RelativePathCalculator;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RelativePathCalculatorTest extends CmsTestCase
{
    /**
     * @var RelativePathCalculator
     */
    protected $calculator;

    public function setUp()
    {
        $this->calculator = new RelativePathCalculator();
    }

    /**
     * @return array[]
     */
    public function pathTests()
    {
        return [
            ['from' => '/', 'to' => '/', 'relative' => './'],
            ['from' => '/abc', 'to' => '/abc', 'relative' => './', 'resolve-to' => '/abc/'],
            ['from' => '/abc/', 'to' => '/abc/', 'relative' => './'],
            //
            ['from' => '/abc', 'to' => '/', 'relative' => '../'],
            ['from' => '/abc/', 'to' => '/', 'relative' => '../'],
            ['from' => '/abc/def', 'to' => '/', 'relative' => '../../'],
            ['from' => '/abc/def/', 'to' => '/', 'relative' => '../../'],
            ['from' => '/abc/def/', 'to' => '/abc', 'relative' => '../', 'resolve-to' => '/abc/'],
            //
            ['from' => '/', 'to' => '/abc', 'relative' => 'abc'],
            ['from' => '/', 'to' => '/abc/def', 'relative' => 'abc/def'],
            ['from' => '/abc', 'to' => '/abc/def', 'relative' => 'def'],
            ['from' => '/abc/', 'to' => '/abc/def', 'relative' => 'def'],
            ['from' => '/abc/def', 'to' => '/123', 'relative' => '../../123'],
            //
            ['from' => '/media/dev/some-project/resources', 'to' => '/media/dev/some-project/resources/doc.pdf', 'relative' => 'doc.pdf'],
            ['from' => '/media/dev/some-project/resources/', 'to' => '/media/dev/some-project/resources/doc.pdf', 'relative' => 'doc.pdf'],
            ['from' => '/media/dev/some-project/resources', 'to' => '/media/dev/doc.pdf', 'relative' => '../../doc.pdf'],
            ['from' => '/media/dev/some-project/resources/', 'to' => '/media/dev/doc.pdf', 'relative' => '../../doc.pdf'],
            //
            ['from' => 'C:\\abc\\foo\\', 'to' => 'C:\\def', 'relative' => '..\\..\\def'],
            //
            ['from' => 's3://some-bucket', 'to' => 's3://some-bucket', 'relative' => './'],
            ['from' => 's3://some-bucket', 'to' => 's3://some-bucket/some/sub/folder', 'relative' => 'some/sub/folder'],
            ['from' => 's3://some-bucket/other', 'to' => 's3://some-bucket/some/sub/folder', 'relative' => '../some/sub/folder'],
            ['from' => 's3://some-bucket/other', 'to' => 'http://some-other-url', 'relative' => 'http://some-other-url'],
        ];
    }

    /**
     * @dataProvider pathTests
     */
    public function testRelativePathCalculator($from, $to, $relative)
    {
        $this->assertSame(
            PathHelper::normalize($relative),
            $this->calculator->getRelativePath($from, $to)
        );
    }

    /**
     * @dataProvider pathTests
     */
    public function testResolveRelativePath($from, $to, $relative, $resolveTo = null)
    {
        $this->assertSame(
            PathHelper::normalize($resolveTo ?: $to),
            $this->calculator->resolveRelativePath($from, $relative)
        );
    }

    public function testRelativeParentOfRoot()
    {
        $this->assertSame(
            PathHelper::normalize('/'),
            $this->calculator->resolveRelativePath('/', '../../')
        );
    }
}