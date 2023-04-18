<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer\Dsn;

use Stringable;

interface DsnInterface extends Stringable
{
    public function __toString(): string;
}
