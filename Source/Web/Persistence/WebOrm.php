<?php

namespace Dms\Common\Structure\Web\Persistence;

use Dms\Common\Structure\Web\EmailAddress;
use Dms\Common\Structure\Web\Html;
use Dms\Common\Structure\Web\IpAddress;
use Dms\Common\Structure\Web\Url;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;

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
                Url::class          => UrlMapper::class,
        ]);
    }
}