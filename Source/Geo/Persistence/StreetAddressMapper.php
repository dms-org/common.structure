<?php

namespace Iddigital\Cms\Common\Structure\Geo\Persistence;

use Iddigital\Cms\Common\Structure\Geo\StreetAddress;
use Iddigital\Cms\Common\Structure\Type\Persistence\StringValueObjectMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;

/**
 * The string address value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressMapper extends StringValueObjectMapper
{
    /**
     * StreetAddressMapper constructor.
     *
     * @param string $addressColumnName
     */
    public function __construct($addressColumnName = 'address')
    {
        parent::__construct($addressColumnName);
    }

    /**
     * Gets the mapped class type.
     *
     * @return string
     */
    protected function classType()
    {
        return StreetAddress::class;
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
        $stringColumn->asVarchar(StreetAddress::MAX_LENGTH);
    }
}