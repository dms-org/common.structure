<?php

namespace Iddigital\Cms\Common\Structure\Geo;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\ValueObject;

/**
 * The string address value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddress extends ValueObject
{
    const ADDRESS = 'address';

    /**
     * @var string
     */
    protected $address;

    /**
     * StringAddress constructor.
     *
     * @param string $address
     *
     * @throws InvalidArgumentException
     */
    public function __construct($address)
    {
        if (!$address) {
            throw InvalidArgumentException::format(
                    'Invalid address string supplied to %s: address cannot be empty',
                    __METHOD__
            );
        }

        parent::__construct();

        $this->address = $address;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->address)->asString();
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}