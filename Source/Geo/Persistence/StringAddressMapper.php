<?php

namespace Iddigital\Cms\Common\Structure\Geo\Persistence;

use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The string address value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $addressColumnName;

    /**
     * StringAddressMapper constructor.
     *
     * @param string $addressColumnName
     */
    public function __construct($addressColumnName = 'address')
    {
        $this->addressColumnName = $addressColumnName;
        parent::__construct();
    }


    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(StringAddress::class);

        $map->property(StringAddress::ADDRESS_STRING)->to($this->addressColumnName)->asVarchar(255);
    }
}