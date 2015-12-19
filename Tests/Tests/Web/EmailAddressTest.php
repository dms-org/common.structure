<?php

namespace Iddigital\Cms\Common\Structure\Tests\Web;

use Iddigital\Cms\Common\Structure\Web\EmailAddress;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EmailAddressTest extends CmsTestCase
{
    public function testEmailAddress()
    {
        $emailAddress = new EmailAddress('test@test.com');

        $this->assertSame('test@test.com', $emailAddress->asString());
    }

    public function testInvalidEmailAddress()
    {
        $invalidEmailAddresses = [
                'abc',
                'test@',
                'test@bbb',
        ];

         foreach ($invalidEmailAddresses as $emailAddressString) {
             $this->assertThrows(function () use($emailAddressString) {
                 new EmailAddress($emailAddressString);
             }, InvalidArgumentException::class);
         }
    }
}