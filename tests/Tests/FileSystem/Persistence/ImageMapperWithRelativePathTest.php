<?php

namespace Dms\Common\Structure\Tests\ImageSystem\Persistence;

use Dms\Common\Structure\FileSystem\Image;
use Dms\Common\Structure\FileSystem\Persistence\ImageMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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
        return new ImageMapper('path', null, '/storage/path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => 'image', 'client_name' => 'aaabbbccc'], new Image('/storage/path/image', 'aaabbbccc')],
                [['path' => 'image/in/sub/dir.gif', 'client_name' => null], new Image('/storage/path/image/in/sub/dir.gif')],
                [['path' => '../parent.bmp', 'client_name' => null], new Image('/storage/parent.bmp')],
                [['path' => '../parent/sub/dir.bmp', 'client_name' => null], new Image('/storage/parent/sub/dir.bmp')],
        ];
    }
}