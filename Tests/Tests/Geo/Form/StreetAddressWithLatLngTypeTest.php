<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\Form\StreetAddressWithLatLngType;
use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Geo\StreetAddressWithLatLng;
use Iddigital\Cms\Common\Structure\Tests\Form\FieldTypeTest;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\FloatValidator;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\TypeValidator;
use Iddigital\Cms\Core\Form\IFieldType;
use Iddigital\Cms\Core\Language\Message;
use Iddigital\Cms\Core\Model\Type\Builder\Type;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressWithLatLngTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new StreetAddressWithLatLngType();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['abc', [new Message(TypeValidator::MESSAGE, ['type' => Type::arrayOf(Type::mixed())->nullable()->asTypeString()])]],
                [
                        [],
                        [
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Address', 'input' => null]),
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Coordinates', 'input' => null]),
                        ],
                ],
                [
                        ['address' => '', 'coordinates' => ['lat' => 'abc', 'lng' => '11abc']],
                        [
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Address', 'input' => '']),
                                new Message(FloatValidator::MESSAGE, ['field' => 'Coordinates > Latitude', 'input' => 'abc']),
                                new Message(FloatValidator::MESSAGE, ['field' => 'Coordinates > Longitude', 'input' => '11abc']),
                        ],
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                [
                        ['address' => '123 Smith St', 'coordinates' => ['lat' => '0', 'lng' => '0']],
                        new StreetAddressWithLatLng('123 Smith St', new LatLng(0.0, 0.0))
                ],
                [
                        ['address' => '555 Evergreen Tce Springfield', 'coordinates' => ['lat' => '-70.134', 'lng' => '120.432']],
                        new StreetAddressWithLatLng('555 Evergreen Tce Springfield', new LatLng(-70.134, 120.432))
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [
                        new StreetAddressWithLatLng('555 Evergreen Tce Springfield', new LatLng(-70.134, 120.432)),
                        ['address' => '555 Evergreen Tce Springfield', 'coordinates' => ['lat' => -70.134, 'lng' => 120.432]],
                ],
                [
                        new StreetAddressWithLatLng('123 Smith St', new LatLng(0.0, 0.0)),
                        ['address' => '123 Smith St', 'coordinates' => ['lat' => 0.0, 'lng' => 0.0]],
                ],
        ];
    }
}