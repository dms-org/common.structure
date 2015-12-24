<?php

namespace Dms\Common\Structure\Tests\Geo\Form;

use Dms\Common\Structure\Geo\Form\StreetAddressType;
use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new StreetAddressType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return StreetAddress::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                [[1, 2, 3], [new Message(TypeValidator::MESSAGE, ['type' => 'string'])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['123 Smith St', new StreetAddress('123 Smith St')],
                ['555 Evergreen Tce Springfield', new StreetAddress('555 Evergreen Tce Springfield')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new StreetAddress('123 Smith St'), '123 Smith St'],
                [new StreetAddress('555 Evergreen Tce Springfield'), '555 Evergreen Tce Springfield'],
        ];
    }
}