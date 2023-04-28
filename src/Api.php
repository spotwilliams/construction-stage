<?php

declare(strict_types=1);

namespace ConstructionStages;

use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;
use ConstructionStages\Http\Router;

class Api
{
    public function __construct()
    {
        $uri = strtolower(trim((string)($_SERVER['PATH_INFO'] ?? ''), '/'));
        $httpVerb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';

        try {
            ['action' => $action, 'params' => $params] = Router::findAction($httpVerb, $uri);
            /** @var ActionContract $handler */

            $handler = new $action;

            $response = $handler->execute(new Request($params));
        } catch (Http\RouteNotFound $e) {
            $response = new Response([
                'error' => 'No such route',
            ]);
        }

        echo $response;

    }
}
