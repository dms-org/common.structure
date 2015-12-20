<?php

namespace Dms\Common\Structure\Tests\Web\Persistence;

use Dms\Common\Structure\Web\Html;
use Dms\Common\Structure\Web\Persistence\HtmlMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HtmlMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new HtmlMapper('html');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['html' => '<p>abc</p>'], new Html('<p>abc</p>')],
                [['html' => '<div>123</div>'], new Html('<div>123</div>')],
        ];
    }
}