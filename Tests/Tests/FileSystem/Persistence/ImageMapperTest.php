<?php

namespace Iddigital\Cms\Common\Structure\Tests\ImageSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\Image;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\ImageMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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
        return new ImageMapper('path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => '/test/abc'], new Image('/test/abc')],
                [['path' => '/pic.png'], new Image('/pic.png')],
                [['path' => str_replace('\\', '/', __FILE__)], new Image(__FILE__)],
        ];
    }
}