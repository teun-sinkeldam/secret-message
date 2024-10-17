<?php

declare(strict_types=1);

namespace App\Service\Uuid;

use Symfony\Component\Uid\Uuid;
class UuidGenerator implements UuidGeneratorInterface
{
    
    public function generate(): string
    {
        return Uuid::v1()->toString();
    }
}
