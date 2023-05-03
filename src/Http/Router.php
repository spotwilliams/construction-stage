<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

class Router
{
    /**
     * @var array An array containing all the registered routes in the format:
     */
    protected static array $routes = [];

    /**
     * @var array An array containing all the wildcards that can be used in the routes.
     * The keys represent the wildcard names, and the values are the regex patterns that will replace them.
     */
    protected static array $wildcards = [
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
    ];

    /**
     * Add a new route to the list of registered routes.
     *
     * @param string $method The HTTP verb of the route (e.g. 'get', 'post', 'put', 'patch', 'delete', etc.).
     * @param string $route The route string (e.g. '/users/:id', '/posts', etc.).
     * @param string $action The action to be executed when the route is matched (it should be the well qualified name).
     * @return array The list of registered routes after adding the new one.
     */
    public static function add(string $method, string $route, string $action): array
    {
        self::$routes [] = ['method' => strtolower($method), 'route' => strtolower($route), 'action' => $action];

        return self::$routes;
    }

    /**
     * Find the action to be executed for the given HTTP verb and URI.
     *
     * @param string $httpVerb The HTTP verb of the request (e.g. 'get', 'post', 'put', 'patch', 'delete', etc.).
     * @param string $uri The URI of the request (e.g. '/', '/users/1', '/posts/new', etc.).
     * @return array An array containing the action to be executed and the parameters to be passed to it.
     * @throws RouteNotFound If no route matches the given HTTP verb and URI.
     */
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

    /**
     * Returns the list of all registered routes, or a filtered list by HTTP verb.
     *
     * @param string|null $verb The HTTP verb to filter by.
     *
     * @return array The list of all registered routes, or a filtered list by HTTP verb.
     */
    public static function routes(string $verb = null): array
    {
        if ($verb)
            return array_filter(self::$routes, fn($route) => $route['method'] === strtolower($verb));

        return self::$routes;
    }
}
