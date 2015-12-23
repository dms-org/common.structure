<?php

namespace Dms\Common\Structure\Geo\Form;

use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Common\Structure\Type\Form\DomainSpecificStringType;

/**
 * The string address field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressType extends DomainSpecificStringType
{
    /**
     * @inheritdoc
     */
    protected function stringValueObjectType()
    {
        return StreetAddress::class;
    }

    /**
     * @inheritdoc
     */
    protected function stringType()
    {
        return null;
    }
}