<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\RelativePathCalculator;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The file or directory value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class FileOrDirectoryMapper extends IndependentValueObjectMapper
{
    const MAX_PATH_LENGTH = 500;
    const MAX_CLIENT_FILE_NAME_LENGTH = 255;

    /**
     * @var string
     */
    protected $pathColumnName;

    /**
     * @var string|null
     */
    protected $clientNameColumnName;

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
     * @var bool
     */
    private $allowInMemoryFiles;

    /**
     * FileOrDirectoryMapper constructor.
     *
     * @param string                      $pathColumnName
     * @param string|null                 $clientNameColumnName
     * @param string|null                 $baseDirectoryPath
     * @param RelativePathCalculator|null $relativePathCalculator
     * @param bool                        $allowInMemoryFiles
     */
    public function __construct(
        string $pathColumnName,
        string $clientNameColumnName = null,
        string $baseDirectoryPath = null,
        RelativePathCalculator $relativePathCalculator = null,
        bool $allowInMemoryFiles = false
    ) {
        if ($baseDirectoryPath) {
            $baseDirectoryPath = (new Directory($baseDirectoryPath))->getFullPath();
        }

        $this->pathColumnName         = $pathColumnName;
        $this->clientNameColumnName   = $clientNameColumnName;
        $this->basePath               = $baseDirectoryPath;
        $this->relativePathCalculator = $relativePathCalculator ?: new RelativePathCalculator();
        $this->allowInMemoryFiles     = $allowInMemoryFiles;

        parent::__construct();
    }

    /**
     * @return string
     */
    abstract protected function classType() : string;

    /**
     * @return string
     */
    abstract protected function fullPathPropertyName() : string;

    /**
     * @return string|null
     */
    abstract protected function clientFileNamePropertyName();

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
            $pathColumn = $map->property($this->fullPathPropertyName())
                ->mappedVia(function ($fullPath) {
                    return $this->relativePathCalculator->getRelativePath($this->basePath, $fullPath);
                }, function ($relativePath) {
                    return $this->relativePathCalculator->resolveRelativePath($this->basePath, $relativePath);
                })
                ->to($this->pathColumnName);
        } else {
            $pathColumn = $map->property($this->fullPathPropertyName())
                ->to($this->pathColumnName);
        }

        if ($this->allowInMemoryFiles) {
            $pathColumn->asText();
        } else {
            $pathColumn->asVarchar(self::MAX_PATH_LENGTH);
        }

        if ($this->clientNameColumnName) {
            $map->property($this->clientFileNamePropertyName())
                ->to($this->clientNameColumnName)
                ->nullable()
                ->asVarchar(self::MAX_CLIENT_FILE_NAME_LENGTH);
        }
    }
}