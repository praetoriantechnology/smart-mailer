<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

enum EncryptionMethod: string
{
    case NO_ENCRYPTION = '';
    case SSLTLS = 'SSL';
    case STARTTLS = 'STARTTLS';
}
