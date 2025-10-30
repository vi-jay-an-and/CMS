<?php

namespace App\Core;

class Response
{
    public function __construct(private int $status = 200, private array $headers = ['Content-Type' => 'application/json'], private mixed $body = null)
    {
    }

    public static function json(mixed $data, int $status = 200): self
    {
        return new self($status, ['Content-Type' => 'application/json'], $data);
    }

    public static function error(string $message, int $status = 400): self
    {
        return self::json(['error' => $message], $status);
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        if (is_array($this->body) || is_object($this->body)) {
            echo json_encode($this->body);
            return;
        }

        echo (string) $this->body;
    }
}
