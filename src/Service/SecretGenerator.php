<?php

declare(strict_types=1);

namespace App\Service;

class SecretGenerator
{
    public function generate(): string
    {
        return (string) rand(100000, 999999);
    }
}
