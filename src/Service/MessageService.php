<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Service\Secret\SecretGeneratorInterface;
use App\Service\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class MessageService
{
    public function __construct(
        private readonly MessageRepository $messageRepository,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly SecretGeneratorInterface $secretGenerator,
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
