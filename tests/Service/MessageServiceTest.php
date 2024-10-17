<?php

declare(strict_types=1);

namespace App\Test;

use App\Service\MessageService;
use App\Service\SecretGenerator;
use App\Service\UuidGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MessageServiceTest extends TestCase
{
    private MockObject|SecretGenerator $mockSecretGenerator;
    private MockObject|UuidGenerator $mockUuidGenerator;
    private MessageService $messageService;

    protected function setUp(): void
    {
        $this->mockSecretGenerator = $this->createMock(SecretGenerator::class);
        $this->mockUuidGenerator = $this->createMock(UuidGenerator::class);
        $this->messageService = new MessageService($this->mockUuidGenerator, $this->mockSecretGenerator);
    }
    public function testCreate(): void
    {
        $this->mockSecretGenerator->method('generate')->willReturn('111111');
        $this->mockUuidGenerator->method('generate')->willReturn('WOW SUCH A NICE UUID');

        $message = $this->messageService->createMessage('message!', 'recipient!');
        $this->assertEquals('111111', $message->getSecret());
        $this->assertEquals('WOW SUCH A NICE UUID', $message->getUuid());
    }
}
