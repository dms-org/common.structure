<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Type;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

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
    final public function __construct(string $string)
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
    abstract protected function validateString(string $string);

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
    final public function asString() : string
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