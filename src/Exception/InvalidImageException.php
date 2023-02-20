<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer\Exception;

class InvalidImageException extends SmartMailerException
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('File `%s` is not an image.', $path));
    }
}
