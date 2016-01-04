<?php

namespace Dms\Common\Structure\Tests\Colour\Persistence;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\Mapper\ColourMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ChannelsColourMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return ColourMapper::asChannelColumns('colour_');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['colour_red' => 10, 'colour_green' => 100, 'colour_blue' => 150], new Colour(10, 100, 150)],
                [['colour_red' => 0, 'colour_green' => 0, 'colour_blue' => 0], new Colour(0, 0, 0)],
                [['colour_red' => 255, 'colour_green' => 255, 'colour_blue' => 255], new Colour(255, 255, 255)],
        ];
    }
}