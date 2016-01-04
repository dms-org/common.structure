<?php

namespace Dms\Common\Structure\Colour;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

/**
 * The colour value object
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Colour extends ValueObject
{
    const RED = 'red';
    const GREEN = 'green';
    const BLUE = 'blue';

    /**
     * @var int
     */
    protected $red;

    /**
     * @var int
     */
    protected $green;

    /**
     * @var int
     */
    protected $blue;

    /**
     * Colour constructor.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @throws InvalidArgumentException
     */
    public function __construct($red, $green, $blue)
    {
        parent::__construct();

        foreach (['red' => $red, 'green' => $green, 'blue' => $blue] as $channel => $value) {
            if ($value < 0 || $value > 255) {
                throw InvalidArgumentException::format(
                        'Invalid %s channel value supplied to %s: expecting integer between 0 and 255, %d given',
                        $channel, __METHOD__, $value
                );
            }
        }

        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->red)->asInt();

        $class->property($this->green)->asInt();

        $class->property($this->blue)->asInt();
    }

    /**
     * Creates a new colour from the supplied rgb string value
     *
     * @param string $string eg: "rgb(100, 100, 100)"
     *
     * @return Colour
     * @throws InvalidArgumentException
     */
    public static function fromRgbString($string)
    {
        list($r, $g, $b) = ColourStringParser::parseRgbString($string);

        return new self($r, $g, $b);
    }

    /**
     * Creates a new colour from the supplied hex value
     *
     * @param string $string
     *
     * @return Colour
     */
    public static function fromHexString($string)
    {
        list($r, $g, $b) = ColourStringParser::parseHexString($string);

        return new self($r, $g, $b);
    }

    /**
     * @return int
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * @return int
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * @return int
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Gets the colour as a rgb string.
     *
     * @return string
     */
    public function toRgbString()
    {
        return "rgb({$this->red}, {$this->green}, {$this->blue})";
    }

    /**
     * Gets the colour as a hex string.
     *
     * @return string
     */
    public function toHexString()
    {
        return '#' . sprintf('%02x', $this->red) . sprintf('%02x', $this->green) . sprintf('%02x', $this->blue);
    }

    /**
     * Returns this colour with the supplied alpha channel.
     *
     * @param float $alphaChannel
     *
     * @return TransparentColour
     */
    public function withTransparency($alphaChannel)
    {
        return new TransparentColour($this, $alphaChannel);
    }
}