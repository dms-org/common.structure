<?php

namespace Dms\Common\Structure\Tests\ImageSystem\Persistence;

use Dms\Common\Structure\FileSystem\Image;
use Dms\Common\Structure\FileSystem\Persistence\ImageMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new ImageMapper('path', 'client_name');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => '/test/abc', 'client_name' => null], new Image('/test/abc')],
                [['path' => '/pic.png', 'client_name' => 'foo.png'], new Image('/pic.png', 'foo.png')],
                [['path' => str_replace('\\', '/', __FILE__), 'client_name' => null], new Image(__FILE__)],
        ];
    }
}