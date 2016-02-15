<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Colour\Form;

use Dms\Common\Structure\Colour\Colour;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\StringType;
use Dms\Core\Form\IFieldProcessor;
use Dms\Core\Model\Type\Builder\Type;

/**
 * The colour field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ColourType extends StringType
{
    /**
     * @return IFieldProcessor[]
     */
    protected function buildProcessors() : array
    {
        return array_merge(parent::buildProcessors(), [
                new RgbColourValidator(Type::string()->nullable()),
                new CustomProcessor(
                        Colour::type(),
                        function ($input) {
                            return Colour::fromRgbString($input);
                        },
                        function (Colour $colour) {
                            return $colour->toRgbString();
                        }
                )
        ]);
    }
}