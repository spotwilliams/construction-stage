<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

interface ActionContract
{
    public function execute(Request $request): Response;
}
