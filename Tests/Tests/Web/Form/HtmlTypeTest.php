<?php

namespace Dms\Common\Structure\Tests\Web\Form;

use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Common\Structure\Web\Form\HtmlType;
use Dms\Common\Structure\Web\Html;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HtmlTypeTest extends FieldTypeTest
{

    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new HtmlType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Html::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                [[1, 2, 3], [new Message(TypeValidator::MESSAGE, ['type' => 'string'])]]
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                [null, null],
                ['<p>abc</p>', new Html('<p>abc</p>')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new Html('<p>abc</p>'), '<p>abc</p>'],
        ];
    }
}