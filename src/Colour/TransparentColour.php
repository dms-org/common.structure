<?php

namespace Dms\Common\Structure\Colour;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

/**
 * The transparent colour value object
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TransparentColour extends ValueObject
{
    const COLOUR = 'colour';
    const ALPHA = 'alpha';

    /**
     * @var Colour
     */
    protected $colour;

    /**
     * @var float
     */
    protected $alpha;

    /**
     * TransparentColour constructor.
     *
     * @param Colour $colour
     * @param float  $alpha
     *
     * @throws InvalidArgumentException
     */
    public function __construct(Colour $colour, $alpha)
    {
        parent::__construct();

        if ($alpha < 0 || $alpha > 1) {
            throw InvalidArgumentException::format(
                    'Invalid alpha channel value supplied to %s: expecting float between 0 and 1, %d given',
                    __METHOD__, $alpha
            );
        }

        $this->colour = $colour;
        $this->alpha  = $alpha;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->colour)->asObject(Colour::class);

        $class->property($this->alpha)->asFloat();
    }

    /**
     * Creates a new colour from the supplied rgba values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @param float $alpha
     *
     * @return TransparentColour
     */
    public static function fromRgba($red, $green, $blue, $alpha)
    {
        return new self(new Colour($red, $green, $blue), $alpha);
    }

    /**
     * Creates a new colour from the supplied rgba string value
     *
     * @param string $string eg: "rgba(100, 100, 100, 0.5)"
     *
     * @return TransparentColour
     * @throws InvalidArgumentException
     */
    public static function fromRgbaString($string)
    {
        list($r, $g, $b, $a) = ColourStringParser::parseRgbaString($string);

        return new self(new Colour($r, $g, $b), $a);
    }

    /**
     * @return int
     */
    public function getRed()
    {
        return $this->colour->getRed();
    }

    /**
     * @return int
     */
    public function getGreen()
    {
        return $this->colour->getGreen();
    }

    /**
     * @return int
     */
    public function getBlue()
    {
        return $this->colour->getBlue();
    }

    /**
     * @return float
     */
    public function getAlpha()
    {
        return $this->alpha;
    }

    /**
     * @return Colour
     */
    public function withoutTransparency()
    {
        return $this->colour;
    }

    /**
     * Gets the colour as a rgba string.
     *
     * @return string
     */
    public function toRgbaString()
    {
        return "rgba({$this->colour->getRed()}, {$this->colour->getGreen()}, {$this->colour->getBlue()}, {$this->alpha})";
    }
}