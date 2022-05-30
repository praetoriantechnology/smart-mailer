<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

interface SmartMailerInterface
{
    public function send(Message $message);
}
