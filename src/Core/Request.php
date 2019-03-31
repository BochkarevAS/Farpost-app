<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private $request;

    private $query;

    private $requestUri;

    public function __construct(array $query = [], array $request = [])
    {
        $this->query   = $query;
        $this->request = $request;
    }

    public static function createRequest()
    {
        return new static($_GET, $_POST);
    }

    public function query(string $key)
    {
        if (in_array($key, $this->query)) {
            return $this->query[$key];
        }

        return null;
    }

    public function request(string $key)
    {
        if (in_array($key, $this->request)) {
            return $this->request[$key];
        }

        return null;
    }

    public function getRequestUri()
    {
        if (null === $this->requestUri) {
            $this->requestUri = $this->prepareRequestUri();
        }

        return $this->requestUri;
    }

    protected function prepareRequestUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        return $uri;
    }
}