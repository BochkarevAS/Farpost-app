<?php

declare(strict_types=1);

namespace App\Psr;

interface ContainerInterface
{
    public function get(string $id);

    public function has(string $id): bool;
}