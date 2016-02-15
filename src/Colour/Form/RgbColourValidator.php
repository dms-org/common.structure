<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Colour\Form;

use Dms\Common\Structure\Colour\ColourStringParser;
use Dms\Core\Form\Field\Processor\FieldValidator;
use Dms\Core\Language\Message;

/**
 * The rgb colour string validator
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class RgbColourValidator extends FieldValidator
{
    const MESSAGE = 'validation.colour.rgb';

    /**
     * Validates the supplied input and adds an
     * error messages to the supplied array.
     *
     * @param mixed     $input
     * @param Message[] $messages
     */
    protected function validate($input, array &$messages)
    {
        if (!preg_match(ColourStringParser::REGEX_RGB, $input)) {
            $messages[] = new Message(self::MESSAGE);
        }
    }
}