<?php

namespace Dms\Common\Structure\Tests\Web\Form;

use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Common\Structure\Web\IpAddress;
use Dms\Common\Structure\Web\Form\IpAddressType;
use Dms\Core\Form\Field\Processor\Validator\IpAddressValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class IpAddressTypeTest extends FieldTypeTest
{

    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new IpAddressType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return IpAddress::type()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['abc', [new Message(IpAddressValidator::MESSAGE, [])]],
                ['124.343.532', [new Message(IpAddressValidator::MESSAGE, [])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['123.123.123.123', new IpAddress('123.123.123.123')],
                ['FE80:0000:0000:0000:0202:B3FF:FE1E:8329', new IpAddress('FE80:0000:0000:0000:0202:B3FF:FE1E:8329')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new IpAddress('123.123.123.123'), '123.123.123.123'],
                [new IpAddress('FE80:0000:0000:0000:0202:B3FF:FE1E:8329'), 'FE80:0000:0000:0000:0202:B3FF:FE1E:8329'],
        ];
    }
}