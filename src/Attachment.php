<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

use Praetorian\SmartMailer\Exception\InvalidAttachmentException;

class Attachment
{
    protected string $path;

    public function __construct(string $path, protected ?string $name = null)
    {
        $this->setPath($path);
    }

    private function setPath(string $path): self
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidAttachmentException($path);
        }

        $this->path = $path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
