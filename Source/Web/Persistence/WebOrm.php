<?php

namespace Iddigital\Cms\Common\Structure\Web\Persistence;

use Iddigital\Cms\Common\Structure\Web\EmailAddress;
use Iddigital\Cms\Common\Structure\Web\Html;
use Iddigital\Cms\Common\Structure\Web\IpAddress;
use Iddigital\Cms\Common\Structure\Web\Uri;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Orm;

/**
 * The orm containing web value object mappers.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class WebOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->valueObjects([
                EmailAddress::class => EmailAddressMapper::class,
                Html::class         => HtmlMapper::class,
                IpAddress::class    => IpAddressMapper::class,
                Uri::class          => UriMapper::class,
        ]);
    }
}