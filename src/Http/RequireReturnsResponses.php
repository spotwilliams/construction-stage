<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

trait RequireReturnsResponses
{
    public function response(array $data, int $httpCode = 200): Response
    {
        http_response_code($httpCode);
        return new Response($data);
    }
}
