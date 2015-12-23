<?php

namespace Dms\Common\Structure\Web\Form;

use Dms\Common\Structure\Type\Form\DomainSpecificStringType;
use Dms\Common\Structure\Web\EmailAddress;

/**
 * The email address field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EmailAddressType extends DomainSpecificStringType
{
    /**
     * @inheritdoc
     */
    protected function stringValueObjectType()
    {
        return EmailAddress::class;
    }

    /**
     * @inheritdoc
     */
    protected function stringType()
    {
        return self::TYPE_EMAIL;
    }
}