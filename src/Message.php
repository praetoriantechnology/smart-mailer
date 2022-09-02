<?php

declare(strict_types=1);

namespace Praetorian\SmartMailer;

use Praetorian\SmartMailer\Exception\NotUniqueEmbedNameException;

class Message
{
    protected ?array $to = null;
    protected ?array $cc = null;
    protected ?array $bcc = null;
    protected ?array $context = null;

    protected ?array $attachments = null;
    protected ?array $images = null;

    protected ?EmailAddress $from = null;
    protected ?string $html = null;
    protected ?string $text = null;

    protected ?string $subject = null;

    public function getTo(): ?array
    {
        return $this->to;
    }

    public function setTo(array $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function getCc(): ?array
    {
        return $this->cc;
    }

    public function setCc(array $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function getBcc(): ?array
    {
        return $this->bcc;
    }

    public function setBcc(array $bcc): self
    {
        $this->bcc = $bcc;

        return $this;
    }

    public function addTo(EmailAddress $emailAddress)
    {
        return $this->addAddress($this->to, $emailAddress);
    }

    public function removeTo(EmailAddress $emailAddress)
    {
        return $this->removeAddress($this->to, $emailAddress);
    }

    public function hasTo(EmailAddress $emailAddress)
    {
        return $this->hasAddress($this->to, $emailAddress);
    }

    public function addCc(EmailAddress $emailAddress)
    {
        return $this->addAddress($this->cc, $emailAddress);
    }

    public function removeCc(EmailAddress $emailAddress)
    {
        return $this->removeAddress($this->cc, $emailAddress);
    }

    public function hasCc(EmailAddress $emailAddress)
    {
        return $this->hasAddress($this->cc, $emailAddress);
    }

    public function addBcc(EmailAddress $emailAddress)
    {
        return $this->addAddress($this->bcc, $emailAddress);
    }

    public function removeBcc(EmailAddress $emailAddress)
    {
        return $this->removeAddress($this->bcc, $emailAddress);
    }

    public function hasBcc(EmailAddress $emailAddress)
    {
        return $this->hasAddress($this->bcc, $emailAddress);
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(?string $html): self
    {
        $this->html = $html;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getFrom(): ?EmailAddress
    {
        return $this->from;
    }

    public function setFrom(?EmailAddress $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }

    public function setContext(?array $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment)
    {
        if (!is_array($this->attachments)) {
            $this->attachments = [];
        }

        $this->attachments[] = $attachment;

        return $this;
    }

    public function hasAttachment(Attachment $attachment)
    {
        if (empty($this->attachments)) {
            return false;
        }

        if (array_search($attachment, $this->getAttachments(), true)) {
            return true;
        }

        return false;
    }

    public function removeAttachemnt(Attachment $attachment)
    {
        while ($key = array_search($attachment, $this->getAttachments() ?? [], true)) {
            unset($this->attachments[$key]);
        }

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function hasImageKey(string $name)
    {
        return is_array($this->images) ? isset($this->images[$name]) : false;
    }

    public function addImage(Attachment $attachment)
    {
        if (!is_array($this->images)) {
            $this->images = [];
        }

        $name = $this->getImageName($attachment);

        if ($this->hasImageKey($name)) {
            throw new NotUniqueEmbedNameException($name);
        }

        $this->images[$name] = $attachment;

        return $this;
    }

    public function hasImage(Attachment $attachment)
    {
        if (empty($this->images)) {
            return false;
        }

        if (array_search($attachment, $this->getImages(), true)) {
            return true;
        }

        return false;
    }

    public function removeImageByKey(string $name)
    {
        if (empty($this->images)) {
            return $this;
        }

        if (!$this->hasImageKey($name)) {
            return $this;
        }

        unset($this->images[$name]);

        return $this;
    }

    public function removeImage(Attachment $attachment)
    {
        while ($key = array_search($attachment, $this->getImages() ?? [], true)) {
            unset($this->images[$key]);
        }
    }

    private function hasAddress($collection, EmailAddress $address)
    {
        return isset($collection[(string) $address]);
    }

    private function addAddress(&$collection, EmailAddress $address)
    {
        if (!is_array($collection)) {
            $collection = [];
        }

        $collection[(string) $address] = $address;

        return $this;
    }

    private function removeAddress(&$collection, EmailAddress $emailAddress)
    {
        if (!is_array($collection)) {
            return $this;
        }
    }

    private function getImageName(Attachment $image)
    {
        return !empty($image->getName()) ? $image->getName() : basename($image->getPath());
    }
}
