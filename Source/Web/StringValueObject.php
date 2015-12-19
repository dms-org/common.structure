<?php

namespace Iddigital\Cms\Common\Structure\Web;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\ValueObject;

/**
 * The string value object base class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class StringValueObject extends ValueObject
{
    const STRING = 'string';

    /**
     * @var string
     */
    protected $string;

    /**
     * StringValueObject constructor.
     *
     * @param string $string
     */
    final public function __construct($string)
    {
        $this->validateString($string);
        parent::__construct();

        $this->string = $string;
    }

    /**
     * Validates the string is in the required format.
     *
     * @param string $string
     *
     * @return void
     * @throws InvalidArgumentException
     */
    abstract protected function validateString($string);

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    final protected function define(ClassDefinition $class)
    {
        $class->property($this->string)->asString();
    }

    /**
     * Gets the string which this value object represents.
     *
     * @return string
     */
    final public function asString()
    {
        return $this->string;
    }

    /**
     * @inheritDoc
     */
    protected function dataToSerialize()
    {
        return $this->string;
    }

    /**
     * @inheritDoc
     */
    protected function hydrateFromSerializedData($deserializedData)
    {
        return $this->string = $deserializedData;
    }


}