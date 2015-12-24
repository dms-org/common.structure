<?php

namespace Dms\Common\Structure\Tests\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\Persistence\FileMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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