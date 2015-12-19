<?php

namespace Iddigital\Cms\Common\Structure\Tests\Web;

use Iddigital\Cms\Common\Structure\Web\Uri;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;

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