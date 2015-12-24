<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\Web\Form\EmailAddressType;
use Dms\Common\Structure\Web\Form\HtmlType;
use Dms\Common\Structure\Web\Form\IpAddressType;
use Dms\Common\Structure\Web\Form\UrlType;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class WebFieldsTest extends CmsTestCase
{
    public function testEmailAddress()
    {
        $type = Field::forType()->email()
                ->build()
                ->getType();

        $this->assertInstanceOf(EmailAddressType::class, $type);
    }

    public function testHtml()
    {
        $type = Field::forType()->html()
                ->build()
                ->getType();

        $this->assertInstanceOf(HtmlType::class, $type);
    }

    public function testIpAddress()
    {
        $type = Field::forType()->ipAddress()
                ->build()
                ->getType();

        $this->assertInstanceOf(IpAddressType::class, $type);
    }

    public function testUrl()
    {
        $type = Field::forType()->url()
                ->build()
                ->getType();

        $this->assertInstanceOf(UrlType::class, $type);
    }
}