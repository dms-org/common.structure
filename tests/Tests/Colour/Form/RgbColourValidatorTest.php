<?php

namespace Dms\Common\Structure\Tests\Colour\Form;

use Dms\Common\Structure\Colour\Form\RgbColourValidator;
use Dms\Core\Form\Field\Processor\FieldValidator;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Core\Model\Type\IType;
use Dms\Core\Tests\Form\Field\Processor\Validator\FieldValidatorTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RgbColourValidatorTest extends FieldValidatorTest
{
    /**
     * @return FieldValidator
     */
    protected function validator()
    {
        return new RgbColourValidator(Type::string());
    }

    /**
     * @return IType
     */
    protected function processedType()
    {
        return Type::string();
    }

    /**
     * @return array[]
     */
    public function successTests()
    {
        return [
                ['rgb(0, 0, 0)'],
                ['rgb(0,0,0)'],
                ['rgb(10, 100, 150)'],
                ['rgb(255, 255, 255)'],
        ];
    }

    /**
     * @return array[]
     */
    public function failTests()
    {
        return [
                ['rgsfa', [new Message(RgbColourValidator::MESSAGE)]],
                ['rgba(0,0,0)', [new Message(RgbColourValidator::MESSAGE)]],
                ['rgb(0,0,0,0)', [new Message(RgbColourValidator::MESSAGE)]],
        ];
    }
}