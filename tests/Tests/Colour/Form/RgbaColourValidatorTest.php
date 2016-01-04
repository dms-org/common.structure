<?php

namespace Dms\Common\Structure\Tests\Colour\Form;

use Dms\Common\Structure\Colour\Form\RgbaColourValidator;
use Dms\Core\Form\Field\Processor\FieldValidator;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Core\Model\Type\IType;
use Dms\Core\Tests\Form\Field\Processor\Validator\FieldValidatorTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RgbaColourValidatorTest extends FieldValidatorTest
{

    /**
     * @return FieldValidator
     */
    protected function validator()
    {
        return new RgbaColourValidator(Type::string());
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
            ['rgba(0, 0, 0, 0)'],
            ['rgba(0,0,0,0)'],
            ['rgba(10, 100, 150, 0.5)'],
            ['rgba(255, 255, 255, 1)'],
        ];
    }

    /**
     * @return array[]
     */
    public function failTests()
    {
        return [
                ['rgsfa', [new Message(RgbaColourValidator::MESSAGE)]],
                ['rgba(0,0,0)', [new Message(RgbaColourValidator::MESSAGE)]],
        ];
    }
}