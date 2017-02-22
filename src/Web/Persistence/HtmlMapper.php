<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Web\Persistence;

use Dms\Common\Structure\Type\Persistence\StringValueObjectMapper;
use Dms\Common\Structure\Web\Html;
use Dms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;

/**
 * The html value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HtmlMapper extends StringValueObjectMapper
{
    /**
     * @var bool
     */
    protected $longText = false;

    /**
     * @inheritDoc
     */
    public function __construct(string $columnName = 'html', bool $longText = false)
    {
        $this->longText = $longText;
        parent::__construct($columnName);
    }

    /**
     * @param string $columnName
     *
     * @return HtmlMapper
     */
    public static function withLongText(string $columnName): self
    {
        return new self($columnName, true);
    }

    /**
     * Gets the mapped class type.
     *
     * @return string
     */
    protected function classType(): string
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
        if ($this->longText) {
            $stringColumn->asLongText();
        } else {
            $stringColumn->asText();
        }
    }
}