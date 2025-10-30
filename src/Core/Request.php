<?php

namespace App\Core;

class Request
{
    public function __construct(private array $server, private array $get, private array $post, private array $body)
    {
    }

    public static function capture(): self
    {
        $content = file_get_contents('php://input');
        $decoded = json_decode($content, true);

        return new self($_SERVER, $_GET, $_POST, is_array($decoded) ? $decoded : []);
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function path(): string
    {
        if (isset($this->get['path']) && is_string($this->get['path'])) {
            return $this->get['path'];
        }

        $uri = $this->server['REQUEST_URI'] ?? '/';
        $pos = strpos($uri, '?');

        return $pos === false ? $uri : substr($uri, 0, $pos);
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }

        return $this->body[$key] ?? $default;
    }

    public function json(): array
    {
        return $this->body;
    }
}
