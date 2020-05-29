<?php

declare(strict_types=1);

namespace App\Form;

use App\Core\Request;

interface FormInterface
{
    public function isValid(): bool;

    public function isSubmitted(): bool;

    public function handleRequest(Request $request = null);
}