<?php

namespace Dms\Common\Structure\Geo;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

/**
 * The string address with lat/lng value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressWithLatLng extends ValueObject
{
    const ADDRESS = 'address';
    const LAT_LNG = 'latLng';

    /**
     * @var string
     */
    protected $address;

    /**
     * @var LatLng
     */
    protected $latLng;

    /**
     * StringAddressWithLatLng constructor.
     *
     * @param string $address
     * @param LatLng $latLng
     *
     * @throws InvalidArgumentException
     */
    public function __construct($address, LatLng $latLng)
    {
        if(!$address) {
            throw InvalidArgumentException::format('Invalid address passed to %s: address cannot be empty', __CLASS__);
        }

        parent::__construct();
        $this->address = $address;
        $this->latLng  = $latLng;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->address)->asString();
        $class->property($this->latLng)->asObject(LatLng::class);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return LatLng
     */
    public function getLatLng()
    {
        return $this->latLng;
    }
}
