<?php

namespace Dms\Common\Structure\FileSystem;

/**
 * The directory / file path helper class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class PathHelper
{
    /**
     * Normalizes the supplied path
     *
     * @param string $path
     *
     * @return string
     */
    public static function normalize(string $path) : string
    {
        if (strpos($path, 'data://') === 0) {
            return $path;
        }


        $path = self::stringReplaceIgnoringStreamWrapper(['\\', '/'], DIRECTORY_SEPARATOR, $path);

        $startOfPath = strpos($path, '://') === false ? 0 : strpos($path, '://') + strlen('://');

        while (strpos($path, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, $startOfPath) !== false) {
            $path = self::stringReplaceIgnoringStreamWrapper(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $path);
        }

        return $path;
    }

    /**
     * Combines the supplied paths
     *
     * @param string[] $paths
     *
     * @return string
     */
    public static function combine(string ... $paths) : string
    {
        $paths = array_map([__CLASS__, 'normalize'], $paths);

        $paths = array_filter($paths, function ($path) {
            return trim($path, DIRECTORY_SEPARATOR) !== '.';
        });

        $combinedPath = implode(DIRECTORY_SEPARATOR, $paths);

        return self::stringReplaceIgnoringStreamWrapper(
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR,
            DIRECTORY_SEPARATOR,
            $combinedPath
        );
    }

    /**
     * @param string|array $toReplace
     * @param string|array $replacement
     * @param string       $fullPath
     *
     * @return string
     */
    protected static function stringReplaceIgnoringStreamWrapper($toReplace, $replacement, string $fullPath):string
    {
        if (strpos($fullPath, '://') !== false) {
            list($streamWrapper, $path) = explode('://', $fullPath, 2);

            return $streamWrapper . '://' . ltrim(str_replace(
                $toReplace,
                $replacement,
                $path
            ), DIRECTORY_SEPARATOR);
        } else {
            return str_replace($toReplace, $replacement, $fullPath);
        }
    }
}