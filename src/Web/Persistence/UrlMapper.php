<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Web\Persistence;

use Dms\Common\Structure\Type\Persistence\StringValueObjectMapper;
use Dms\Common\Structure\Web\Url;
use Dms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;

/**
 * The ur; value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UrlMapper extends StringValueObjectMapper
{
    /**
     * @inheritDoc
     */
    public function __construct($columnName = 'uri')
    {
        parent::__construct($columnName);
    }

    /**
     * Gets the mapped class type.
     *
     * @return string
     */
    protected function classType() : string
    {
        return Url::class;
    }

    /**
     * Defines the column type for the string property.
     *
     * @param ColumnTypeDefiner $stringColumn
     *
     * @return void
     */
    protected function defineStringColumnType(ColumnTypeDefiner $stringColumn)
    {
        $stringColumn->asVarchar(Url::MAX_LENGTH);
    }
}