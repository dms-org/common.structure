<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\Form\StreetAddressType;
use Iddigital\Cms\Common\Structure\Geo\StreetAddress;
use Iddigital\Cms\Common\Structure\Tests\Form\FieldTypeTest;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\TypeValidator;
use Iddigital\Cms\Core\Form\IFieldType;
use Iddigital\Cms\Core\Language\Message;

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
     * @return array[]
     */
    public function validationTests()
    {
        return [
                [[1, 2, 3], [new Message(TypeValidator::MESSAGE, ['expected_type' => 'string', 'actual_type' => 'array'])]],
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