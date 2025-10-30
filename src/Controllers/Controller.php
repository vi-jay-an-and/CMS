<?php

namespace App\Controllers;

use App\Core\Response;

abstract class Controller
{
    protected function ok(array $data): Response
    {
        return Response::json($data);
    }

    protected function created(array $data): Response
    {
        return Response::json($data, 201);
    }

    protected function error(string $message, int $status = 400): Response
    {
        return Response::error($message, $status);
    }
}
