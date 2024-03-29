Praetorian Technology: Smart Mailer
===================================

![Tests status](https://github.com/praetoriantechnology/smart-mailer/workflows/tests/badge.svg)
![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/praetoriantechnology/smart-mailer?label=latest%20version&sort=semver)

Smart mailer is a simple library which assits sending of emails with use of
symfony/mailer component. At the moment it requires SMTP connection, but grants
features like easy embedding of images, easier attachments adding, exceptions
tracking and use of string templates instead of files.

Sample use:
```php
<?php

declare(strict_types=1);

use Praetorian\SmartMailer\Attachment;
use Praetorian\SmartMailer\EmailAddress;
use Praetorian\SmartMailer\Message;
use Praetorian\SmartMailer\SmartMailer;
use Praetorian\SmartMailer\Smtp;

include 'vendor/autoload.php';

$from = new EmailAddress('jaroslaw@kaczynski.pl', 'Jaroslaw Kaczynski');
$to = new EmailAddress('andrzej@duda.pl', 'Andrzej Duda');

$smtp = new Smtp();
$smtp->setHost('smtp.sample.com')
    ->setPort(465)
    ->setUsername('username')
    ->setPassword('password')
     ;

$image1 = new Attachment();
$image1->setPath('sample.png')
       ;

$message = new Message();
$message->setFrom($from)
    ->addTo($to)
    ->setHtml('<html><head><title>test</title></head><body>{{ variable }} <img src="cid:sample.png" alt="test"/></body></html>')
    ->addImage($image1)
    ->setSubject('sample mail title')
    ->setContext([
        'variable' => 'sample text',
    ])
        ;

$mailer = new SmartMailer($smtp);

$mailer->send($message);
```

You can easily embed any image by using `content id` of the resource. If your
filename is `sample.png` then to embed just place `cid:sample.png` in contents.
You can also define a custom name:
```php
$image1->setName('othername')
```

Then the substitution will be `cid:othername`.

Warning: it is required for the name to be unique!

Roadmap
=======

1.0: tests, comments
2.0: other transports than SMTP Servers
3.0: Pub/Sub queues support

# Contribution

Any pull requests or issues reported are more than welcome.

# License

GPL 3+