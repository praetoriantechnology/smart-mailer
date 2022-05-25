<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

class InvalidAttachmentException extends SmartMailerException
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('File `%s` must exist and be readable.', $path));
    }
}
