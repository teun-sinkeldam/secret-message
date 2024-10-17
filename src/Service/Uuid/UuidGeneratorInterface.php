<?php

declare(strict_types=1);

namespace App\Service\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
