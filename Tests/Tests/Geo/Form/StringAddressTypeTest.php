<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\Form\StringAddressType;
use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Common\Structure\Tests\Form\FieldTypeTest;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\TypeValidator;
use Iddigital\Cms\Core\Form\IFieldType;
use Iddigital\Cms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new StringAddressType();
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
                ['123 Smith St', new StringAddress('123 Smith St')],
                ['555 Evergreen Tce Springfield', new StringAddress('555 Evergreen Tce Springfield')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new StringAddress('123 Smith St'), '123 Smith St'],
                [new StringAddress('555 Evergreen Tce Springfield'), '555 Evergreen Tce Springfield'],
        ];
    }
}