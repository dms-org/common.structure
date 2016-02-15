<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Colour\Mapper;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\ColourStringParser;
use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The transparent TransparentColour value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TransparentColourMapper extends IndependentValueObjectMapper
{
    const MODE_RGBA_STRING = 'rgb-string';
    const MODE_CHANNELS = 'channels-as-columns';

    /**
     * @var string
     */
    private $storageMode;
    /**
     * @var string
     */
    private $columnName;

    public function __construct($storageMode = self::MODE_RGBA_STRING, $columnName = 'colour')
    {
        $this->storageMode = $storageMode;
        $this->columnName  = $columnName;

        parent::__construct();
    }

    /**
     * Stores the colour as a rgba(...) string.
     *
     * @param string $columnName
     *
     * @return TransparentColourMapper
     */
    public static function asRgbaString(string $columnName) : TransparentColourMapper
    {
        return new self(self::MODE_RGBA_STRING, $columnName);
    }


    /**
     * Stores the colour channels as individual columns named (red, green, blue).
     *
     * @param string $columnPrefix
     *
     * @return TransparentColourMapper
     */
    public static function asChannelColumns(string $columnPrefix = '') : TransparentColourMapper
    {
        return (new self(self::MODE_CHANNELS))->withColumnsPrefixedBy($columnPrefix);
    }

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(TransparentColour::class);

        switch ($this->storageMode) {
            case self::MODE_RGBA_STRING:
                $map->accessor(
                        function (TransparentColour $colour) {
                            return $colour->toRgbaString();
                        },
                        function (TransparentColour $colour, $string) {
                            list($r, $g, $b, $a) = ColourStringParser::parseRgbaString($string);
                            $colour->hydrate([
                                    TransparentColour::COLOUR => new Colour($r, $g, $b),
                                    TransparentColour::ALPHA  => $a,
                            ]);
                        }
                )->to($this->columnName)->asVarchar(25);
                break;

            case self::MODE_CHANNELS:
            default:
                $map->embedded(TransparentColour::COLOUR)->using(ColourMapper::asChannelColumns());
                $map->property(TransparentColour::ALPHA)->to('alpha')->asDecimal(3, 2);
                break;
        }
    }
}