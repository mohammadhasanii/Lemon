<?php

declare(strict_types=1);

namespace Lemon\Protection\Middlwares;

use Lemon\Http\Request;
use Lemon\Http\Response;
use Lemon\Http\ResponseFactory;
use Lemon\Protection\Csrf as ProtectionCsrf;

class Csrf
{
    public function handle(Request $request, ProtectionCsrf $csrf, ResponseFactory $responseFactory, Response $response)
    {
        if ('GET' != $request->method) {
            $cookie = $request->getCookie('CSRF_TOKEN');
            if ($cookie !== $request->get('CSRF_TOKEN') || null === $cookie) {
                return $responseFactory->error(400);
            }
        }

        return $response->cookie('CSRF_TOKEN', $csrf->getToken());
    }
}
