<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private $request = [];

    private $query = [];

    private $requestUri;

    public $attributes = [];

    public function __construct(array $query = [], array $request = [])
    {
        $this->query   = $query;
        $this->request = $request;
    }

    public static function createRequest()
    {
        return new static($_GET, $_POST);
    }

    public function query(string $key): string
    {
        return $this->query[$key] ?? '';
    }

    public function request(string $key): string
    {
        return $this->request[$key] ?? '';
    }

    public function getSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        return $_SESSION;
    }

    public function setSession(string $key, string $value)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION[$key] = $value;

        return $_SESSION;
    }

    public function getRequestUri()
    {
        if (null === $this->requestUri) {
            $this->requestUri = $this->prepareRequestUri();
        }

        return $this->requestUri;
    }

    protected function prepareRequestUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        return $uri;
    }
}