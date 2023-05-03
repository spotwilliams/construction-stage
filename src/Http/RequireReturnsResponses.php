<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

trait RequireReturnsResponses
{
    /**
     * Create a new response object with the given data and HTTP status code.
     *
     * @param array $data An array of data to include in the response body.
     * @param int $httpCode The HTTP status code for the response.
     *
     * @return Response A new Response object with the given data and HTTP status code.
     */
    public function response(array $data, int $httpCode = 200): Response
    {
        http_response_code($httpCode);
        return new Response($data);
    }
}
