<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

use Exception;
use Praetorian\SmartMailer\Exception\InvalidEmailMessageException;
use Praetorian\SmartMailer\Exception\SendException;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SmartMailer implements SmartMailerInterface
{
    protected ?Environment $twig = null;

    public function __construct(protected Smtp $smtp, ?Environment $twig = null)
    {
        $this->twig = $twig ?? $this->createDummyTwig();
    }

    public function getSmtp(): Smtp
    {
        return $this->smtp;
    }

    public function setSmtp(Smtp $smtp): self
    {
        $this->smtp = $smtp;

        return $this;
    }

    public function validate(Message $message)
    {
        if (!$message->getFrom()) {
            throw new InvalidEmailMessageException('Missing `from`.');
        }

        if (empty($message->getTo()) && empty($message->getCc()) && empty($message->getBcc())) {
            throw new InvalidEmailMessageException('Message must have at least one recipient.');
        }

        if (empty($message->getHtml()) && empty($message->getText())) {
            throw new InvalidEmailMessageException('Message must have at least one (html, text) body.');
        }

        return true;
    }

    public function send(Message $message)
    {
        $this->validate($message);

        $smtp = $this->getSmtp();
        $dsn = sprintf('smtp://%s:%s@%s:%s', $smtp->getUsername(), $smtp->getPassword(), $smtp->getHost(), $smtp->getPort());
        $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);

        $from = $message->getFrom();

        // Generates the email
        $email = new Email();
        $email->addFrom(
            new Address($from->getAddress(), $from->getName() ?? '')
        );

        $email->subject($message->getSubject() ?? '');

        /* @var EmailAddress */
        foreach ($message->getTo() ?? [] as $to) {
            $email->addTo(new Address($to->getAddress(), $to->getName() ?? ''));
        }

        /* @var EmailAddress */
        foreach ($message->getCc() ?? [] as $to) {
            $email->addCc(new Address($to->getAddress(), $to->getName() ?? ''));
        }

        /* @var EmailAddress */
        foreach ($message->getBcc() ?? [] as $to) {
            $email->addBcc(new Address($to->getAddress(), $to->getName() ?? ''));
        }

        if ($message->getHtml()) {
            $template = $this->twig->createTemplate($message->getHtml(), 'email_html_body');
            $rendered = $template->render($message->getContext() ?? []);
            $email->html($rendered);
        }

        if ($message->getText()) {
            $template = $this->twig->createTemplate($message->getText(), 'email_html_body');
            $rendered = $template->render($message->getContext() ?? []);
            $email->text($rendered);
        }

        /* @var Attachment */
        foreach ($message->getAttachments() ?? [] as $attachment) {
            $email->attachFromPath($attachment->getPath(), $attachment->getName());
        }

        foreach ($message->getImages() ?? [] as $name => $attachment) {
            $email->embedFromPath($attachment->getPath(), $name);
        }

        try {
            $mailer->send($email);
        } catch (Exception $e) {
            throw new SendException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function createDummyTwig(): Environment
    {
        $loader = new FilesystemLoader('.');

        return new Environment($loader);
    }
}
