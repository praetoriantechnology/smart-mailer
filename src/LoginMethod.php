<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

enum LoginMethod: string
{
    case AUTO = '';
    case PLAIN = 'PLAIN';
    case LOGIN = 'LOGIN';
    case CRAM_MD5 = 'CRAM-MD5';
    case DIGEST_MD5 = 'DIGEST-MD5';
}
