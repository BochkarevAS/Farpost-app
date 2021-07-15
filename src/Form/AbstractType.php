<?php

declare(strict_types=1);

namespace App\Form;

use App\Core\Request;

abstract class AbstractType implements FormInterface
{
    protected ?string $submitted = null;

    protected array $errors = [];

    public function isValid(): bool
    {
        return 0 === count($this->getErrors());
    }

    public function isSubmitted(): bool
    {
        return $this->submitted ? true : false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    abstract public function handleRequest(Request $request = null);
}