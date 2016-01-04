<?php

namespace Dms\Common\Structure\Tests\Colour\Persistence;

use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Common\Structure\Colour\Mapper\TransparentColourMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ChannelsTransparentColourMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return TransparentColourMapper::asChannelColumns('colour_');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['colour_red' => 10, 'colour_green' => 100, 'colour_blue' => 150, 'colour_alpha' => .5],
                        TransparentColour::fromRgba(10, 100, 150, .5)
                ],
                [
                        ['colour_red' => 0, 'colour_green' => 0, 'colour_blue' => 0, 'colour_alpha' => 0.0],
                        TransparentColour::fromRgba(0, 0, 0, 0.0)
                ],
                [
                        ['colour_red' => 255, 'colour_green' => 255, 'colour_blue' => 255, 'colour_alpha' => 1],
                        TransparentColour::fromRgba(255, 255, 255, 1.0)
                ],
        ];
    }
}