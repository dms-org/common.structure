<?php

namespace Iddigital\Cms\Common\Structure\Table\Persistence;

use Iddigital\Cms\Common\Structure\Table\TableData;
use Iddigital\Cms\Common\Structure\Table\TableDataCell;
use Iddigital\Cms\Core\Model\ValueObjectCollection;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IOrm;
use Iddigital\Cms\Core\Persistence\Db\Mapping\ValueObjectMapper;

/**
 * The table data value object base mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class TableDataMapper extends ValueObjectMapper
{
    /**
     * @var string
     */
    protected $tableDataClass;

    /**
     * @inheritDoc
     */
    public function __construct(IOrm $orm, $parentMapper)
    {
        $this->tableDataClass = $this->tableDataClass();
        parent::__construct($orm, $parentMapper);
    }

    /**
     * @return string
     */
    abstract protected function tableDataClass();

    /**
     * The table name to which the data is saved to.
     *
     * @return string
     */
    abstract protected function tableName();

    /**
     * The name of the primary key.
     *
     * @return string
     */
    protected function tablePrimaryKey()
    {
        return 'id';
    }

    /**
     * The name of the foreign key to the parent table.
     *
     * @return string
     */
    abstract protected function foreignKeyName();

    /**
     * Defines the value object mapper for the cells contained within the table.
     *
     * @see TableDataCell
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    abstract protected function defineCellMapper(MapperDefinition $map);

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type($this->tableDataClass);

        $map->ignoreUnmappedProperties();

        $map->accessorRelation(
                function (TableData $table) {
                    return $table->asCellCollection();
                },
                function (TableData $table, ValueObjectCollection $cells) {
                    $table->hydrateFromCellCollection($cells);
                }
        )->asEmbedded()->collection()
                ->toTable($this->tableName())
                ->withPrimaryKey($this->tablePrimaryKey())
                ->withForeignKeyToParentAs($this->foreignKeyName())
                ->usingCustom(function (MapperDefinition $map) {
                    $map->type(TableDataCell::class);

                    $this->defineCellMapper($map);
                });
    }
}