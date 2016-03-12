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
     * @return string
     */
    public static function normalize(string $path) : string
    {
        if (strpos($path, 'data://') === 0) {
            return $path;
        }

        return str_replace(['\\\\', '//', '\\', '/'], DIRECTORY_SEPARATOR, $path);
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
        return str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, array_map([__CLASS__, 'normalize'], $paths)));
    }
}