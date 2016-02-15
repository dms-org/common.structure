<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Geo;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;

/**
 * The coordinate value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LatLng extends ValueObject
{
    const LAT = 'lat';
    const LNG = 'lng';

    /**
     * @var float
     */
    protected $lat;

    /**
     * @var float
     */
    protected $lng;

    /**
     * LatLng constructor.
     *
     * @param float $lat must be between -90 and 90
     * @param float $lng must be between -180 and 180
     *
     * @throws InvalidArgumentException
     */
    public function __construct(float $lat, float $lng)
    {
        if ($lat < -90 || $lat > 90) {
            throw InvalidArgumentException::format(
                    'Invalid latitude supplied to %s: must between -90 and 90, %d given',
                    __METHOD__, $lat
            );
        }

        if ($lng < -180 || $lng > 180) {
            throw InvalidArgumentException::format(
                    'Invalid longitude supplied to %s: must between -180 and 180, %d given',
                    __METHOD__, $lng
            );
        }

        parent::__construct();
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->lat)->asFloat();
        $class->property($this->lng)->asFloat();
    }

    /**
     * @return float
     */
    public function getLat() : float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng() : float
    {
        return $this->lng;
    }
}