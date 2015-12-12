<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The date or time range value object mapper base class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class DateOrTimeRangeMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $startColumnName;

    /**
     * @var string
     */
    protected $endColumnName;

    /**
     * DateOrTimeRangeMapper constructor.
     *
     * @param string $startColumnName
     * @param string $endColumnName
     */
    public function __construct($startColumnName, $endColumnName)
    {
        $this->startColumnName = $startColumnName;
        $this->endColumnName   = $endColumnName;
        parent::__construct();
    }
}