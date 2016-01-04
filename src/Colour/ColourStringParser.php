<?php

namespace Dms\Common\Structure\Colour;

use Dms\Core\Exception\InvalidArgumentException;

/**
 * The colour formatter class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ColourStringParser
{
    const REGEX_RGB = '/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/';
    const REGEX_RGBA = '/^rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*(\d*(?:\.\d+)?)\)$/';
    const REGEX_HEX = '/^#(?:[0-9a-fA-F]{3}){1,2}$/';

    /**
     * Parses the supplied rgb string into an array of channels.
     *
     * @param string $string eg: "rgb(100, 100, 100)"
     *
     * @return int[] eg: [100, 100, 100]
     * @throws InvalidArgumentException
     */
    public static function parseRgbString($string)
    {
        if (!preg_match(self::REGEX_RGB, $string, $matches)) {
            throw InvalidArgumentException::format(
                    'Invalid rgb string passed to %s: expecting format "rgb(0-255, 0-255, 0-255)", "%s" given',
                    __METHOD__, $string
            );
        }

        return [(int)$matches[1], (int)$matches[2], (int)$matches[3]];
    }

    /**
     * Parses the supplied hex string into an array of channels.
     *
     * @param string $string
     *
     * @return \int[] eg: [100, 100, 100]
     * @throws InvalidArgumentException
     */
    public static function parseHexString($string)
    {
        if (!preg_match(self::REGEX_HEX, $string, $matches)) {
            throw InvalidArgumentException::format(
                    'Invalid rgba string passed to %s: expecting format "#...", "%s" given',
                    __METHOD__, $string
            );
        }

        $string = str_replace('#', '', $string);

        if (strlen($string) === 3) {
            $r = hexdec($string[0] . $string[0]);
            $g = hexdec($string[1] . $string[1]);
            $b = hexdec($string[2] . $string[2]);
        } else {
            $r = hexdec($string[0] . $string[1]);
            $g = hexdec($string[2] . $string[3]);
            $b = hexdec($string[4] . $string[5]);
        }

        return [(int)$r, (int)$g, (int)$b];
    }

    /**
     * Parses the supplied rgba string into an array of channels.
     *
     * @param string $string eg: "rgba(100, 100, 100, 0.5)"
     *
     * @return int[] eg: [100, 100, 100, 0.5]
     * @throws InvalidArgumentException
     */
    public static function parseRgbaString($string)
    {
        if (!preg_match(self::REGEX_RGBA, $string, $matches)) {
            throw InvalidArgumentException::format(
                    'Invalid rgba string passed to %s: expecting format "rgb(0-255, 0-255, 0-255, 0-1)", "%s" given',
                    __METHOD__, $string
            );
        }

        return [(int)$matches[1], (int)$matches[2], (int)$matches[3], (float)$matches[4]];
    }
}