<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class FakeFileSmartMailer extends SmartMailer implements SmartMailerInterface
{
    protected ?Environment $twig = null;

    public function __construct(protected string $outputPath, ?Environment $twig = null)
    {
        $this->twig = $twig ?? $this->createDummyTwig();
    }

    public function setOutputPath(string $outputPath): self
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    public function send(Message $message)
    {
        $this->validate($message);
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
            $email->attach($attachment->getPath(), $attachment->getName());
        }

        foreach ($message->getImages() ?? [] as $name => $attachment) {
            $email->embedFromPath($attachment->getPath(), $name, 'image/png');
        }

        $emailDta = [
            'from' => $email->getFrom(),
            'to' => $email->getTo(),
            'subject' => $email->getSubject(),
            'html' => $email->getHtmlBody(),
        ];

        file_put_contents($this->getOutputPath(), json_encode($emailDta));
    }
}
