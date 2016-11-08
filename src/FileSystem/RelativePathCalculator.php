<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Exception\InvalidArgumentException;

/**
 * Calculates the relative path between two absolute paths.
 *
 * Majority of the code sourced from:
 *
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
    public function getRelativePath(string $fromDir, string $to) : string
    {
        if (strpos($to, 'data://') === 0) {
            return $to;
        }

        list($fromStreamWrapper, $fromDirPath) = $this->splitStreamWrapperAndPath($fromDir);
        list($toStreamWrapper, $toPath) = $this->splitStreamWrapperAndPath($to);

        if ($fromStreamWrapper !== $toStreamWrapper) {
            return $to;
        }

        // some compatibility fixes for Windows paths
        $fromDirPath = str_replace('\\', '/', $fromDirPath);
        $toPath      = str_replace('\\', '/', $toPath);

        if (substr($fromDirPath, -1) !== '/') {
            $fromDirPath .= '/';
        }

        // Optimize common case where $to is a sub path of $from
        if (strpos($toPath, $fromDirPath) === 0) {
            return PathHelper::normalize(substr($toPath, strlen($fromDirPath)) ?: './');
        }

        $fromDirPath = explode('/', $fromDirPath);
        $toPath      = explode('/', $toPath);
        $relPath     = $toPath;

        foreach ($fromDirPath as $depth => $dir) {
            // find first non-matching dir
            if (isset($toPath[$depth]) && $dir === $toPath[$depth]) {
                // ignore this directory
                array_shift($relPath);
            } else {
                // get number of remaining dirs to $from
                $remaining = count($fromDirPath) - $depth;
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

        return PathHelper::normalize(
            $relPath === '..' || $relPath === '.'
                ? $relPath . '/'
                : $relPath
        );
    }

    /**
     * Combines the two paths and resolves '..' and '.' relative traversals.
     *
     * @param string $basePath
     * @param string $relativePath
     *
     * @return string
     */
    public function resolveRelativePath(string $basePath, string $relativePath) : string
    {
        if (strpos($relativePath, 'data://') === 0) {
            return $relativePath;
        }

        list($basePathStreamWrapper, $basePath) = $this->splitStreamWrapperAndPath($basePath);
        list($relativeStreamWrapper, $relativePathWithoutStreamWrapper) = $this->splitStreamWrapperAndPath($relativePath);

        $isAbsolutePath = $relativeStreamWrapper !== null;

        if ($isAbsolutePath) {
            return $relativePath;
        } else {
            $relativePath = $relativePathWithoutStreamWrapper;
        }

        $basePath     = str_replace('\\', '/', $basePath);
        $relativePath = str_replace('\\', '/', $relativePath);

        if (substr($basePath, -1) !== '/') {
            $basePath .= '/';
        }

        if (strpos($relativePath, '.') === false) {
            return ($basePathStreamWrapper ? $basePathStreamWrapper . '://' : '')
            . PathHelper::normalize(str_replace('//', '/', $basePath . '/' . $relativePath));
        }

        $parts          = explode('/', $basePath);
        $relativeParts  = explode('/', trim($relativePath, '/'));
        $isDrivePath    = substr($basePath, 1, 1) === ':';
        $precedingSlash = $basePathStreamWrapper || $isDrivePath ? '' : '/';
        $trailingSlash  = !$basePathStreamWrapper && substr($relativePath, -1) === '/' ? '/' : '';

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

        return ($basePathStreamWrapper ? $basePathStreamWrapper . '://' : '')
        . PathHelper::normalize($precedingSlash . implode('/', $parts) . ($parts ? $trailingSlash : ''));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function splitStreamWrapperAndPath(string $path) : array
    {
        if (strpos($path, '://') !== false) {
            list($streamWrapper, $path) = explode('://', $path, 2);
            return [$streamWrapper, $path];
        } else {
            return [null, $path];
        }
    }
}