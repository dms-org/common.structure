<?php

namespace Dms\Common\Structure\Web\Form;

use Dms\Common\Structure\Type\Form\DomainSpecificStringType;
use Dms\Common\Structure\Web\IpAddress;

/**
 * The ip address field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class IpAddressType extends DomainSpecificStringType
{
    /**
     * @inheritdoc
     */
    protected function stringValueObjectType()
    {
        return IpAddress::class;
    }

    /**
     * @inheritdoc
     */
    protected function stringType()
    {
        return self::TYPE_IP_ADDRESS;
    }
}