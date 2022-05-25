<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

class InvalidEmailAddressException extends SmartMailerException
{
    public function __construct(string $textProvided)
    {
        parent::__construct(sprintf('Provided value of: `%s` is not a valid e-mail address.', $textProvided));
    }
}
