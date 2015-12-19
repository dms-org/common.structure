<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\Form\LatLngType;
use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Tests\Form\FieldTypeTest;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\FloatValidator;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\GreaterThanOrEqualValidator;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\LessThanOrEqualValidator;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Iddigital\Cms\Core\Form\Field\Processor\Validator\TypeValidator;
use Iddigital\Cms\Core\Form\IFieldType;
use Iddigital\Cms\Core\Language\Message;
use Iddigital\Cms\Core\Model\Type\Builder\Type;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LatLngTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new LatLngType();
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
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Latitude', 'input' => null]),
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Longitude', 'input' => null]),
                        ],
                ],
                [
                        ['lat' => 'abc', 'lng' => '11abc'],
                        [
                                new Message(FloatValidator::MESSAGE, ['field' => 'Latitude', 'input' => 'abc']),
                                new Message(FloatValidator::MESSAGE, ['field' => 'Longitude', 'input' => '11abc']),
                        ],
                ],
                [
                        ['lat' => '-90.01', 'lng' => '-180.1'],
                        [
                                new Message(GreaterThanOrEqualValidator::MESSAGE, ['field' => 'Latitude', 'input' => '-90.01', 'value' => -90.0]),
                                new Message(GreaterThanOrEqualValidator::MESSAGE, ['field' => 'Longitude', 'input' => '-180.1', 'value' => -180.0]),
                        ],
                ],
                [
                        ['lat' => '90.01', 'lng' => '180.1'],
                        [
                                new Message(LessThanOrEqualValidator::MESSAGE, ['field' => 'Latitude', 'input' => '90.01', 'value' => 90.0]),
                                new Message(LessThanOrEqualValidator::MESSAGE, ['field' => 'Longitude', 'input' => '180.1', 'value' => 180.0]),
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
                [['lat' => '0', 'lng' => '0'], new LatLng(0.0, 0.0)],
                [['lat' => '-70.134', 'lng' => '120.432'], new LatLng(-70.134, 120.432)],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new LatLng(0.0, 0.0), ['lat' => 0.0, 'lng' => 0.0]],
                [new LatLng(-70.134, 120.432), ['lat' => -70.134, 'lng' => 120.432]],
        ];
    }
}