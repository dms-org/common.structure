<?php

namespace Dms\Common\Structure\Tests\Web\Form;

use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Common\Structure\Web\EmailAddress;
use Dms\Common\Structure\Web\Form\EmailAddressType;
use Dms\Core\Form\Field\Processor\Validator\EmailValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EmailAddressTypeTest extends FieldTypeTest
{

    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new EmailAddressType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return EmailAddress::type()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['abc', [new Message(EmailValidator::MESSAGE, [])]],
                ['adsfdf@gsgsdg', [new Message(EmailValidator::MESSAGE, [])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['test@test.com', new EmailAddress('test@test.com')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new EmailAddress('test@test.com'), 'test@test.com'],
        ];
    }
}