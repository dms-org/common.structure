<?php

namespace Iddigital\Cms\Common\Structure\FileSystem;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;

/**
 * Calculates the relative path between two absolute paths.
 *
 * Majority of the code sourced from:
 * @see    http://stackoverflow.com/questions/2637945/getting-relative-path-from-absolute-path-in-php
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RelativePathCalculator
{
    /**
     * Gets the relative path from the first path to the second path.
     *
     * @param string $fromDir
     * @param string $to
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function getRelativePath($fromDir, $to)
    {
        // some compatibility fixes for Windows paths
        $fromDir = str_replace('\\', '/', $fromDir);
        $to      = str_replace('\\', '/', $to);

        if (substr($fromDir, -1) !== '/') {
            $fromDir .= '/';
        }

        // Optimize common case where $to is a sub path of $from
        if (strpos($to, $fromDir) === 0) {
            return substr($to, strlen($fromDir)) ?: './';
        }

        $fromDir = explode('/', $fromDir);
        $to      = explode('/', $to);
        $relPath = $to;

        foreach ($fromDir as $depth => $dir) {
            // find first non-matching dir
            if (isset($to[$depth]) && $dir === $to[$depth]) {
                // ignore this directory
                array_shift($relPath);
            } else {
                // get number of remaining dirs to $from
                $remaining = count($fromDir) - $depth;
                if ($remaining > 1) {
                    // add traversals up to first matching dir
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath   = array_pad($relPath, $padLength, '..');
                    break;
                } else {
                    $relPath[0] = './' . (isset($relPath[0]) ? $relPath[0] : '');
                }
            }
        }

        $relPath = implode('/', $relPath);

        if ($relPath === '..' || $relPath === '.') {
            return $relPath . '/';
        } else {
            return $relPath;
        }
    }

    /**
     * Combines the two paths and resolves '..' and '.' relative traversals.
     *
     * @param string $basePath
     * @param string $relativePath
     *
     * @return string
     */
    public function resolveRelativePath($basePath, $relativePath)
    {
        $basePath     = str_replace('\\', '/', $basePath);
        $relativePath = str_replace('\\', '/', $relativePath);

        if (substr($basePath, -1) !== '/') {
            $basePath .= '/';
        }

        if (strpos($relativePath, '.') === false) {
            return str_replace('//', '/', $basePath . '/' . $relativePath);
        }

        $parts         = explode('/', $basePath);
        $relativeParts = explode('/', trim($relativePath, '/'));
        $trailingSlash = substr($relativePath, -1) === '/' ? '/' : '';

        foreach ($parts as $key => $part) {
            if ($part === '') {
                unset($parts[$key]);
            }
        }

        foreach ($relativeParts as $part) {
            if ($part === '.') {
                continue;
            } elseif ($part === '..') {
                array_pop($parts);
            } elseif ($part !== '') {
                $parts[] = $part;
            }
        }

        return '/' . implode('/', $parts) . ($parts ? $trailingSlash : '');
    }
}