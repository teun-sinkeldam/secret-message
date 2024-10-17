<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Service\MessageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/message', name: 'message_')]
class MessageController
{
    public function __construct(
        private readonly MessageService $messageService,
        private readonly MessageRepository $messageRepository,
        private readonly RouterInterface $router,
    ) {
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): JsonResponse
    {
        // TODO use a serializer to validate and create a request data object
        $payload = $request->getPayload();
        $content = $payload->get('content');
        $recipient = $payload->get('recipient');

        $message = $this->messageService->createMessage($content, $recipient);
        $this->messageRepository->save($message);

        // TODO create response object and use serializer to create response content
        return new JsonResponse(['url' => $this->router->generate('message_view', ['uuid' => $message->getUuid()]), 'secret' => $message->getSecret()]);
    }

    #[Route('/view/{uuid:message}', name: 'view')]
    public function view(Message $message, Request $request): JsonResponse
    {
        // TODO use a serializer to validate and create a request data object
        $this->messageRepository->delete($message);
       
        $payload = $request->getPayload();
        $secret = $payload->get('secret');
        
        // TODO create response object and use serializer to create response content
        if ($message->getSecret() !== $secret) {
            return new JsonResponse(['content' => 'Wrong secret passed, message deleted. sorry :('], Response::HTTP_FORBIDDEN);
        }

        // TODO create response object and use serializer to create response content
        return new JsonResponse(['content' => $message->getContent(), 'recipient' => $message->getRecipient()]);
    }
}
