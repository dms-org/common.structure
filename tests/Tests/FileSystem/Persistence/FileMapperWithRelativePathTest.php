<?php

namespace Dms\Common\Structure\Tests\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\Persistence\FileMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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
        return new FileMapper('path', null, '/storage/path');
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