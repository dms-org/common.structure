<?php

namespace Dms\Common\Structure\Web\Form;

use Dms\Common\Structure\Type\Form\DomainSpecificStringType;
use Dms\Common\Structure\Web\Html;

/**
 * The html field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HtmlType extends DomainSpecificStringType
{
    /**
     * @inheritdoc
     */
    protected function stringValueObjectType()
    {
        return Html::class;
    }

    /**
     * @inheritdoc
     */
    protected function stringType()
    {
        return self::TYPE_HTML;
    }
}