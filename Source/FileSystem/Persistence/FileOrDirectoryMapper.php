<?php

namespace Iddigital\Cms\Common\Structure\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\RelativePathCalculator;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The file or directory value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class FileOrDirectoryMapper extends IndependentValueObjectMapper
{
    const MAX_PATH_LENGTH = 500;

    /**
     * @var string
     */
    protected $pathColumnName;

    /**
     * The directory path which to store the file paths relative to
     * or NULL if the absolute path should be stored.
     *
     * @var string|null
     */
    protected $basePath;

    /**
     * @var RelativePathCalculator
     */
    protected $relativePathCalculator;

    /**
     * FileOrDirectoryMapper constructor.
     *
     * @param string      $pathColumnName
     * @param string|null $baseDirectoryPath
     */
    public function __construct($pathColumnName, $baseDirectoryPath = null)
    {
        if ($baseDirectoryPath) {
            $baseDirectoryPath = str_replace('\\', '/', $baseDirectoryPath);

            if (substr($baseDirectoryPath, -1) !== '/') {
                $baseDirectoryPath .= '/';
            }
        }

        $this->pathColumnName         = $pathColumnName;
        $this->basePath               = $baseDirectoryPath;
        $this->relativePathCalculator = new RelativePathCalculator();

        parent::__construct();
    }

    /**
     * @return string
     */
    abstract protected function classType();

    /**
     * @return string
     */
    abstract protected function fullPathPropertyName();

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type($this->classType());

        $map->ignoreUnmappedProperties();

        if ($this->basePath) {
            $map->property($this->fullPathPropertyName())
                    ->mappedVia(function ($fullPath) {
                        return $this->relativePathCalculator->getRelativePath($this->basePath, $fullPath);
                    }, function ($relativePath) {
                        return $this->relativePathCalculator->resolveRelativePath($this->basePath, $relativePath);
                    })
                    ->to($this->pathColumnName)
                    ->asVarchar(self::MAX_PATH_LENGTH);
        } else {
            $map->property($this->fullPathPropertyName())
                    ->to($this->pathColumnName)
                    ->asVarchar(self::MAX_PATH_LENGTH);
        }
    }
}