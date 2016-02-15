<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Web\Form;

use Dms\Common\Structure\Type\Form\DomainSpecificStringType;
use Dms\Common\Structure\Web\Url;

/**
 * The url field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UrlType extends DomainSpecificStringType
{
    /**
     * @inheritdoc
     */
    protected function stringValueObjectType() : string
    {
        return Url::class;
    }

    /**
     * @inheritdoc
     */
    protected function stringType()
    {
        return self::TYPE_URL;
    }
}