<?php

namespace Iddigital\Cms\Common\Structure\Web\Persistence;

use Iddigital\Cms\Common\Structure\Type\Persistence\StringValueObjectMapper;
use Iddigital\Cms\Common\Structure\Web\Html;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;

/**
 * The html value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HtmlMapper extends StringValueObjectMapper
{
    /**
     * @inheritDoc
     */
    public function __construct($columnName = 'html')
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
        return Html::class;
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
        $stringColumn->asText();
    }
}