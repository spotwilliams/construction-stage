<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

class Router
{
    protected static array $routes = [];

    protected static array $wildcards = [
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
    ];

    public static function add(string $method, string $route, string $action): array
    {
        self::$routes [] = ['method' => strtolower($method), 'route' => strtolower($route), 'action' => $action];

        return self::$routes;
    }

    public static function findAction(string $httpVerb, string $uri = '/'): array
    {
        foreach (Router::routes($httpVerb) as ['method' => $method, 'route' => $route, 'action' => $action]) {

            $pattern = str_replace(array_keys(self::$wildcards), array_values(self::$wildcards), $route);

            if (preg_match(pattern: '#^' . $pattern . '$#i', subject: "{$uri}", matches: $matches)) {
                // remove the first element, is the route.
                array_shift($matches);
                $params['routeParam'] = $matches;
                if (in_array($httpVerb, ['post', 'patch'])) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $params['bodyParam'] = $data;
                }

                return ['action' => $action, 'params' => $params];
            }
        }

        throw new RouteNotFound();
    }

    public static function routes(string $verb = null): array
    {
        if ($verb)
            return array_filter(self::$routes, fn($route) => $route['method'] === strtolower($verb));

        return self::$routes;
    }
}
