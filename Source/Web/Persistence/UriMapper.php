<?php

namespace Dms\Common\Structure\Web\Persistence;

use Dms\Common\Structure\Type\Persistence\StringValueObjectMapper;
use Dms\Common\Structure\Web\Uri;
use Dms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;

/**
 * The uri value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UriMapper extends StringValueObjectMapper
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
    protected function classType()
    {
        return Uri::class;
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
        $stringColumn->asVarchar(Uri::MAX_LENGTH);
    }
}