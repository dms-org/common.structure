<?php

namespace Dms\Common\Structure\Colour\Form;

use Dms\Common\Structure\Colour\ColourStringParser;
use Dms\Core\Form\Field\Processor\FieldValidator;
use Dms\Core\Language\Message;

/**
 * The rgba colour string validator
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RgbaColourValidator extends FieldValidator
{
    const MESSAGE = 'validation.colour.rgba';

    /**
     * Validates the supplied input and adds an
     * error messages to the supplied array.
     *
     * @param mixed     $input
     * @param Message[] $messages
     */
    protected function validate($input, array &$messages)
    {
        if (!preg_match(ColourStringParser::REGEX_RGBA, $input)) {
            $messages[] = new Message(self::MESSAGE);
        }
    }
}