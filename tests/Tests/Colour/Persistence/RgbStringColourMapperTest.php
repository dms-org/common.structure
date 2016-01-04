<?php

namespace Dms\Common\Structure\Tests\Colour\Persistence;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\Mapper\ColourMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RgbStringColourMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return ColourMapper::asRgbString('rgb');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['rgb' => 'rgb(10, 100, 150)'], new Colour(10, 100, 150)],
                [['rgb' => 'rgb(0, 0, 0)'], new Colour(0, 0, 0)],
                [['rgb' => 'rgb(255, 255, 255)'], new Colour(255, 255, 255)],
        ];
    }
}