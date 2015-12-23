<?php

namespace Dms\Common\Structure\Tests\Geo\Form;

use Dms\Common\Structure\Geo\Form\StreetAddressWithLatLngType;
use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Geo\StreetAddressWithLatLng;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\FloatValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;

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
     * @inheritDoc
     */
    public function processedType()
    {
        return StreetAddressWithLatLng::type();
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