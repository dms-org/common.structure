<?php

namespace Iddigital\Cms\Common\Structure\Tests\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\File;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\FileMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileMapperWithRelativePathTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new FileMapper('path', '/storage/path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => 'file'], new File('/storage/path/file')],
                [['path' => 'file/in/sub/dir.txt'], new File('/storage/path/file/in/sub/dir.txt')],
                [['path' => '../parent.pdf'], new File('/storage/parent.pdf')],
                [['path' => '../parent/sub/dir.pdf'], new File('/storage/parent/sub/dir.pdf')],
        ];
    }
}