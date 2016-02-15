<?php declare(strict_types = 1);

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
    protected function stringValueObjectType() : string
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