<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

class Smtp
{
    protected string $host;
    protected int $port;
    protected EncryptionMethod $encryption = EncryptionMethod::SSLTLS;
    protected LoginMethod $loginMethod = LoginMethod::LOGIN;
    protected ?string $username;
    protected ?string $password;

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getEncryption(): EncryptionMethod
    {
        return $this->encryption;
    }

    public function setEncryption(EncryptionMethod $encryption): self
    {
        $this->encryption = $encryption;

        return $this;
    }

    public function getLoginMethod(): LoginMethod
    {
        return $this->loginMethod;
    }

    public function setLoginMethod(LoginMethod $loginMethod): self
    {
        $this->loginMethod = $loginMethod;

        return $this;
    }

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
}
