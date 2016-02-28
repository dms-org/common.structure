<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\Colour\Colour;
use Dms\Common\Structure\Colour\Form\ColourType;
use Dms\Common\Structure\Colour\Form\RgbColourValidator;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ColourTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new ColourType();
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Colour::type()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['rgb(0)', [new Message(RgbColourValidator::MESSAGE, ['input' => 'rgb(0)'])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['rgb(0, 0, 0)', new Colour(0, 0, 0)],
                ['rgb(10, 100, 150)', new Colour(10, 100, 150)],
                ['rgb(255, 255, 255)', new Colour(255, 255, 255)],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new Colour(0, 0, 0), 'rgb(0, 0, 0)'],
                [new Colour(10, 100, 150), 'rgb(10, 100, 150)'],
                [new Colour(255, 255, 255), 'rgb(255, 255, 255)'],
        ];
    }
}