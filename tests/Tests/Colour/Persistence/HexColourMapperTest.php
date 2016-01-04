<?php

namespace Dms\Common\Structure\Tests\Colour\Persistence;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\Mapper\ColourMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HexColourMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return ColourMapper::asHexString('hex');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['hex' => '#0a6496'], new Colour(10, 100, 150)],
                [['hex' => '#000000'], new Colour(0, 0, 0)],
                [['hex' => '#ffffff'], new Colour(255, 255, 255)],
        ];
    }
}