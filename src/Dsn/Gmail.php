<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer\Dsn;

class Gmail implements DsnInterface
{
    protected ?string $username;
    protected ?string $password;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('gmail+smtp://%s:%s@default', $this->getUsername(), $this->getPassword());
    }
}

