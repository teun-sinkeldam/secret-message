<?php

declare(strict_types=1);

namespace App\Service\Secret;

class SecretGenerator implements SecretGeneratorInterface
{
    public function generate(): string
    {
        return (string) rand(100000, 999999);
    }
}
