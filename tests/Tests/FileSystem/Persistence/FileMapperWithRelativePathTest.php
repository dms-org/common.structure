<?php

namespace Dms\Common\Structure\Tests\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\PathHelper;
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
                [['path' => PathHelper::normalize('file')], new File('/storage/path/file')],
                [['path' => PathHelper::normalize('file/in/sub/dir.txt')], new File('/storage/path/file/in/sub/dir.txt')],
                [['path' => PathHelper::normalize('../parent.pdf')], new File('/storage/parent.pdf')],
                [['path' => PathHelper::normalize('../parent/sub/dir.pdf')], new File('/storage/parent/sub/dir.pdf')],
        ];
    }
}