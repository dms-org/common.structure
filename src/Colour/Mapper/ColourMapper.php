<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Colour\Mapper;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\ColourStringParser;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The colour value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ColourMapper extends IndependentValueObjectMapper
{
    const MODE_RGB_STRING = 'rgb-string';
    const MODE_HEX_STRING = 'hex-string';
    const MODE_CHANNELS = 'channels-as-columns';

    /**
     * @var string
     */
    private $storageMode;

    /**
     * @var string
     */
    private $columnName;

    public function __construct($storageMode = self::MODE_RGB_STRING, $columnName = 'colour')
    {
        $this->storageMode = $storageMode;
        $this->columnName  = $columnName;
        parent::__construct();
    }

    /**
     * Stores the colour as a rgb(...) string.
     *
     * @param string $columnName
     *
     * @return ColourMapper
     */
    public static function asRgbString(string $columnName) : ColourMapper
    {
        return new self(self::MODE_RGB_STRING, $columnName);
    }

    /**
     * Stores the colour as a hex (#xxxxxx) string.
     *
     * @param string $columnName
     *
     * @return ColourMapper
     */
    public static function asHexString(string $columnName) : ColourMapper
    {
        return new self(self::MODE_HEX_STRING, $columnName);
    }

    /**
     * Stores the colour channels as individual columns named (red, green, blue).
     *
     * @param string $columnPrefix
     *
     * @return ColourMapper
     */
    public static function asChannelColumns(string $columnPrefix = '') : ColourMapper
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
        $map->type(Colour::class);

        switch ($this->storageMode) {
            case self::MODE_RGB_STRING:
                $map->accessor(
                        function (Colour $colour) {
                            return $colour->toRgbString();
                        },
                        function (Colour $colour, $string) {
                            list($r, $g, $b) = ColourStringParser::parseRgbString($string);
                            $colour->hydrate([
                                    Colour::RED   => $r,
                                    Colour::GREEN => $g,
                                    Colour::BLUE  => $b,
                            ]);
                        }
                )->to($this->columnName)->asVarchar(25);
                break;

            case self::MODE_HEX_STRING:
                $map->accessor(
                        function (Colour $colour) {
                            return $colour->toHexString();
                        },
                        function (Colour $colour, $string) {
                            list($r, $g, $b) = ColourStringParser::parseHexString($string);
                            $colour->hydrate([
                                    Colour::RED   => $r,
                                    Colour::GREEN => $g,
                                    Colour::BLUE  => $b,
                            ]);
                        }
                )->to($this->columnName)->asVarchar(10);
                break;

            case self::MODE_CHANNELS:
            default:
                $map->property(Colour::RED)->to('red')->asUnsignedTinyInt();
                $map->property(Colour::GREEN)->to('green')->asUnsignedTinyInt();
                $map->property(Colour::BLUE)->to('blue')->asUnsignedTinyInt();
                break;
        }
    }
}