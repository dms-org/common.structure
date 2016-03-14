<?php

namespace Dms\Common\Structure\Geo\Chart;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Table\Chart\IChartAxis;
use Dms\Core\Table\Chart\Structure\ChartStructure;

/**
 * The geo-map chart base class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class GeoChart extends ChartStructure
{
    /**
     * @var IChartAxis
     */
    private $locationAxis;

    /**
     * @var IChartAxis
     */
    private $valueAxis;


    /**
     * @inheritDoc
     */
    public function __construct(IChartAxis $locationAxis, IChartAxis $valueAxis)
    {
        InvalidArgumentException::verify(
            count($locationAxis->getComponents()) === 1,
            'type axis must contain only one component, %d given',
            count($locationAxis->getComponents())
        );

        parent::__construct([$locationAxis, $valueAxis]);

        $this->locationAxis = $locationAxis;
        $this->valueAxis    = $valueAxis;
    }

    /**
     * @return IChartAxis
     */
    public function getLocationAxis()
    {
        return $this->locationAxis;
    }

    /**
     * @return IChartAxis
     */
    public function getValueAxis()
    {
        return $this->valueAxis;
    }
}