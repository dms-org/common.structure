<?php

namespace Iddigital\Cms\Common\Structure\Tests\Web\Persistence;

use Iddigital\Cms\Common\Structure\Web\Html;
use Iddigital\Cms\Common\Structure\Web\Persistence\HtmlMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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