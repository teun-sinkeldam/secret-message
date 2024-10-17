<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Uid\Uuid;
class UuidGenerator
{
    
    public function generate(): string
    {
        return Uuid::v1()->toString();
    }
}
