<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

class NotUniqueEmbedNameException extends SmartMailerException
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Embedded resource\'s name must be unique, use a different file or set the name explicitly. Used: `%s`.', $name));
    }
}
