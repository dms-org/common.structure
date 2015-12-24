<?php

namespace Dms\Common\Structure\Tests\Web;

use Dms\Common\Structure\Web\Html;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class HtmlTest extends CmsTestCase
{
    public function testHtml()
    {
        $html = new Html('<p>abc</p>');

        $this->assertSame('<p>abc</p>', $html->asString());
    }

    public function testSerialize()
    {
        $html = new Html('<p>abc</p>');

        $this->assertEquals($html, unserialize(serialize($html)));
    }
}