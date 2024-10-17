<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Message;
use App\Service\SecretGenerator;
use App\Service\UuidGenerator;
use DateTimeImmutable;

class MessageService
{
    public function __construct(
        private readonly UuidGenerator $uuidGenerator,
        private readonly SecretGenerator $secretGenerator,
    ) {
    }

    public function createMessage(string $content, string $recipient): Message
    {
        $message = new Message();
        $message->setContent($content);
        $message->setRecipient($recipient);
        $message->setUuid($this->uuidGenerator->generate());
        $message->setCreatedAt(new DateTimeImmutable());
        $message->setSecret($this->secretGenerator->generate());

        return $message;
    }
}
