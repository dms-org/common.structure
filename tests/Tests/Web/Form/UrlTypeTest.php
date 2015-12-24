<?php

namespace Dms\Common\Structure\Tests\Web\Form;

use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Common\Structure\Web\Url;
use Dms\Common\Structure\Web\Form\UrlType;
use Dms\Core\Form\Field\Processor\Validator\UrlValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UrlTypeTest extends FieldTypeTest
{

    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new UrlType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Url::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['abc', [new Message(UrlValidator::MESSAGE, [])]],
                ['adsfdf.fssdfd', [new Message(UrlValidator::MESSAGE, [])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['http://test.com', new Url('http://test.com')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new Url('http://test.com'), 'http://test.com'],
        ];
    }
}