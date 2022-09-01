<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

use Praetorian\SmartMailer\Exception\InvalidEmailAddressException;

class EmailAddress
{
    private string $address;

    public function __construct(string $address, protected ?string $name = null)
    {
        $this->setAddress($address);
    }

    public function __toString()
    {
        return $this->getAddress();
    }

    public function setAddress(string $address): self
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressException($address);
        }

        $this->address = mb_strtolower(trim($address));

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
