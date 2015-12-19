<?php

namespace Iddigital\Cms\Common\Structure\Tests\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\File;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\FileMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new FileMapper('path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => '/test/abc'], new File('/test/abc')],
                [['path' => '/doc.pdf'], new File('/doc.pdf')],
                [['path' => str_replace('\\', '/', __FILE__)], new File(__FILE__)],
        ];
    }
}