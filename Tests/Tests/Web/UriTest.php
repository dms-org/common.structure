<?php

namespace Dms\Common\Structure\Tests\Web;

use Dms\Common\Structure\Web\Uri;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UriTest extends CmsTestCase
{
    public function testUri()
    {
        $uri = new Uri('http://google.com.au');

        $this->assertSame('http://google.com.au', $uri->asString());
    }

    public function testInvalidUri()
    {
        $invalidUris = [
                'abc',
                'google.com.au',
        ];

         foreach ($invalidUris as $uriString) {
             $this->assertThrows(function () use($uriString) {
                 new Uri($uriString);
             }, InvalidArgumentException::class);
         }
    }
}