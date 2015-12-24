<?php

namespace Dms\Common\Structure\Tests\Web;

use Dms\Common\Structure\Web\EmailAddress;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;

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