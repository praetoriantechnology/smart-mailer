<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

class Attachment
{
    protected string $path;
    protected ?string $name = null;

    public function __construct()
    {
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

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
