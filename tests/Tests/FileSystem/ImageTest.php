<?php

namespace Dms\Common\Structure\Tests\ImageSystem;

use Dms\Common\Structure\FileSystem\Image;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidOperationException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageTest extends CmsTestCase
{
    public function testNew()
    {
        $image = new Image(__DIR__ . '/Fixtures/picture.png');

        $this->assertSame(str_replace('\\', '/', __DIR__) . '/Fixtures/picture.png', $image->getFullPath());
        $this->assertSame('picture.png', $image->getName());
        $this->assertSame(true, $image->exists());
        $this->assertSame('png', $image->getExtension());
        $this->assertSame(true, $image->isValidImage());
    }

    public function testInvalidImage()
    {
        $image = new Image(__FILE__);

        $this->assertSame(str_replace('\\', '/', __FILE__), $image->getFullPath());
        $this->assertSame(basename(__FILE__), $image->getName());
        $this->assertSame(true, $image->exists());
        $this->assertSame(false, $image->isValidImage());
        $this->assertSame('php', $image->getExtension());

        $this->assertThrows(function () use ($image) {
            $image->getWidth();
        }, InvalidOperationException::class);

        $this->assertThrows(function () use ($image) {
            $image->getHeight();
        }, InvalidOperationException::class);
    }

    public function testNonExistent()
    {
        $image = new Image(__DIR__ . '/non-existent.png');

        $this->assertSame(str_replace('\\', '/', __DIR__) . '/non-existent.png', $image->getFullPath());
        $this->assertSame('non-existent.png', $image->getName());
        $this->assertSame(false, $image->exists());
        $this->assertSame(false, $image->isValidImage());
        $this->assertSame('png', $image->getExtension());

        $this->assertThrows(function () use ($image) {
            $image->getWidth();
        }, InvalidOperationException::class);

        $this->assertThrows(function () use ($image) {
            $image->getHeight();
        }, InvalidOperationException::class);
    }
}