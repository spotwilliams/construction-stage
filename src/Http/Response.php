<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

class Response
{
    public function __construct(protected array $content)
    {
    }

    public function __toString()
    {
        return json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
