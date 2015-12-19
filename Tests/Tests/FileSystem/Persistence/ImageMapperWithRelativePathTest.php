<?php

namespace Iddigital\Cms\Common\Structure\Tests\ImageSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\Image;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\ImageMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageMapperWithRelativePathTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new ImageMapper('path', '/storage/path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => 'image'], new Image('/storage/path/image')],
                [['path' => 'image/in/sub/dir.gif'], new Image('/storage/path/image/in/sub/dir.gif')],
                [['path' => '../parent.bmp'], new Image('/storage/parent.bmp')],
                [['path' => '../parent/sub/dir.bmp'], new Image('/storage/parent/sub/dir.bmp')],
        ];
    }
}