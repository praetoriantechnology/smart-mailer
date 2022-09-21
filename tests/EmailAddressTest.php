<?php

declare(strict_types=1);

namespace Praetorian\Tests\SmartMailer;

use PHPUnit\Framework\TestCase;
use Praetorian\SmartMailer\EmailAddress;
use Praetorian\SmartMailer\Exception\InvalidEmailAddressException;

class EmailAddressTest extends TestCase
{
    public function testCreateEmailWithoutName(): void
    {
        $address = 'name@domain.com';
        $emailAddress = new EmailAddress($address);

        $this->assertEquals($address, $emailAddress->getAddress());
        $this->assertNull($emailAddress->getName());
    }

    public function testCreateEmailWithName(): void
    {
        $address = 'name@domain.com';
        $name = 'Name';
        $emailAddress = new EmailAddress($address, $name);

        $this->assertEquals($address, $emailAddress->getAddress());
        $this->assertEquals($name, $emailAddress->getName());
    }

    public function testToString(): void
    {
        $address = 'name@domain.com';
        $emailAddress = new EmailAddress($address);

        $this->assertEquals($address, (string) $emailAddress);
    }

    public function testLowercaseEmail(): void
    {
        $address = 'NamE@domain.com';
        $emailAddress = new EmailAddress($address);

        $this->assertEquals(mb_strtolower($address), $emailAddress->getAddress());
        $this->assertNull($emailAddress->getName());
    }

    /**
     * @dataProvider provideInvalidEmailAddresses
     */
    public function testThrowExceptionWhenCreatingEmailAddressWithIncorrectFormat(string $invalidEmail): void
    {
        $this->expectException(InvalidEmailAddressException::class);

        new EmailAddress($invalidEmail);
    }

    public function provideInvalidEmailAddresses(): array
    {
        return [
            [''],
            ['name@'],
            ['name@domain'],
            ['name@.com'],
            ['@domain.com'],
            ['domain.com'],
        ];
    }
}
