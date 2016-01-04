<?php

namespace Dms\Common\Structure\Colour\Form;

use Dms\Common\Structure\Colour\Form\RgbaColourValidator;
use Dms\Common\Structure\Colour\TransparentColour;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\StringType;
use Dms\Core\Form\IFieldProcessor;
use Dms\Core\Model\Type\Builder\Type;

/**
 * The transparent colour field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TransparentColourType extends StringType
{
    /**
     * @return IFieldProcessor[]
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new RgbaColourValidator(Type::string()->nullable()),
                new CustomProcessor(
                        TransparentColour::type(),
                        function ($input) {
                            return TransparentColour::fromRgbaString($input);
                        },
                        function (TransparentColour $colour) {
                            return $colour->toRgbaString();
                        }
                )
        ]);
    }
}