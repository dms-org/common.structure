<?php

namespace Iddigital\Cms\Common\Structure\Geo;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;

/**
 * The string address with lat/lng value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressWithLatLng extends StringAddress
{
    const LAT_LNG = 'latLng';

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
        parent::__construct($address);
        $this->latLng = $latLng;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        parent::define($class);

        $class->property($this->latLng)->asObject(LatLng::class);
    }

    /**
     * @return LatLng
     */
    public function getLatLng()
    {
        return $this->latLng;
    }
}
