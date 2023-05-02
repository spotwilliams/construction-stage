<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\Http\Response;

trait RequireReturnsResponses
{
    public function response(array $data, int $httpCode = 500): Response
    {
        http_response_code($httpCode);
        return new Response($data);
    }
}
