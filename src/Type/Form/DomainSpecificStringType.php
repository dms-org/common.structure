<?php

namespace Dms\Common\Structure\Type\Form;

use Dms\Common\Structure\Type\StringValueObject;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\StringType;
use Dms\Core\Model\Type\Builder\Type;

/**
 * The string value object field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class DomainSpecificStringType extends StringType
{
    public function __construct()
    {
        $stringType = $this->stringType();

        if ($stringType) {
            $this->attributes[self::ATTR_STRING_TYPE] = $stringType;
        }

        parent::__construct();
    }

    /**
     * Gets the string value object class.
     *
     * @see StringValueObject
     *
     * @return string
     */
    abstract protected function stringValueObjectType();

    /**
     * Gets the string type from the self::TYPE_* constants
     * or NULL if there is no specific string type.
     *
     *
     * @return string|null
     */
    abstract protected function stringType();

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        /** @var StringValueObject|string $stringValueObject */
        $stringValueObject = $this->stringValueObjectType();

        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        Type::object($stringValueObject),
                        function ($input) use ($stringValueObject) {
                            return new $stringValueObject($input);
                        },
                        function (StringValueObject $valueObject) {
                            return $valueObject->asString();
                        }
                )
        ]);
    }
}