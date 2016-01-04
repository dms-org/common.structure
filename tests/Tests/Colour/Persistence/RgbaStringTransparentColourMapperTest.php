<?php

namespace Dms\Common\Structure\Tests\Colour\Persistence;

use Dms\Common\Structure\Colour\Mapper\TransparentColourMapper;
use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RgbaStringTransparentColourMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return TransparentColourMapper::asRgbaString('rgba');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['rgba' => 'rgba(10, 100, 150, 0.5)'],
                        TransparentColour::fromRgba(10, 100, 150, .5)
                ],
                [
                        ['rgba' => 'rgba(0, 0, 0, 0)'],
                        TransparentColour::fromRgba(0, 0, 0, 0.0)
                ],
                [
                        ['rgba' => 'rgba(255, 255, 255, 1)'],
                        TransparentColour::fromRgba(255, 255, 255, 1.0)
                ],
        ];
    }
}