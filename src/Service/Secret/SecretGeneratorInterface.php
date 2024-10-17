<?php

declare(strict_types=1);

namespace App\Service\Secret;

interface SecretGeneratorInterface
{
    public function generate(): string;
}
