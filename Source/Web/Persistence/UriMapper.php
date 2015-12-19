<?php

namespace Iddigital\Cms\Common\Structure\Web\Persistence;

use Iddigital\Cms\Common\Structure\Web\IpAddress;
use Iddigital\Cms\Common\Structure\Web\Uri;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;

/**
 * The uri value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UriMapper extends StringValueObjectMapper
{
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