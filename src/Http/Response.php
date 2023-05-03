<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

class Response
{
    /**
     * Create a new Response instance.
     *
     * @param array $content The content to be included in the response body.
     */
    public function __construct(protected array $content)
    {
    }

    /**
     * Convert the Response object to a JSON string.
     *
     * @return string A JSON-encoded string representing the response content.
     */
    public function __toString()
    {
        return json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
