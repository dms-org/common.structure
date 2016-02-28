<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\Colour\Form\RgbaColourValidator;
use Dms\Common\Structure\Colour\Form\TransparentColourType;
use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TransparentColourTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new TransparentColourType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return TransparentColour::type()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
            ['rgba(0)', [new Message(RgbaColourValidator::MESSAGE, ['input' => 'rgba(0)'])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
            ['rgba(0, 0, 0, 0)', TransparentColour::fromRgba(0, 0, 0, 0.0)],
            ['rgba(10, 100, 150, 0.5)', TransparentColour::fromRgba(10, 100, 150, .5)],
            ['rgba(255, 255, 255, 1)', TransparentColour::fromRgba(255, 255, 255, 1.0)],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
            [TransparentColour::fromRgba(0, 0, 0, 0.0), 'rgba(0, 0, 0, 0)'],
            [TransparentColour::fromRgba(10, 100, 150, 0.5), 'rgba(10, 100, 150, 0.5)'],
            [TransparentColour::fromRgba(255, 255, 255, 1.0), 'rgba(255, 255, 255, 1)'],
        ];
    }
}