<?php

class Router
{
    private $request;
    private $supportedHttpMethods = array(
        "GET",
        "POST",
    );
    private $dynamicRoutes = array();

    function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    function __call($name, $args)
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
            return;
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     */
    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        $result = ltrim($result, '/');
        $result = explode("?", $result)[0];
        // if there is a '{' inside of the route we add it to the dynamic routes
        if(strpos($result, '{') !== false){
            array_push($this->dynamicRoutes, $result);
        }
        if ($result === '') {
            return 'portfolio';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("405 Method Not Allowed");
        http_response_code(405);
    }

    private function defaultRequestHandler()
    {
        echo("404 Not Found<br>Request uri : " . $this->request->requestUri . '<br>Formated route : ' . 
        $this->formatRoute($this->request->requestUri));
        http_response_code(404);
    }

    /**
     * Resolves a route
     */
    function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $dynamicRoute = $this->isADynamicRoute($formatedRoute);

        // if the route is a dynamic one, we send all the parameters to the function and exit the function
        if($dynamicRoute !== false){
            $method = $methodDictionary[$dynamicRoute['route']];
            echo call_user_func_array($method, $dynamicRoute['parameters']);
            return;
        }

        if (!isset($methodDictionary[$formatedRoute])) {
            $this->defaultRequestHandler();
            return;
        }

        $method = $methodDictionary[$formatedRoute];

        echo call_user_func_array($method, array($this->request));
    }

    /**
     * Check if the route is dynamic
     * @param string $route
     * @return $dynamicRoute if the requestUri is one of the dynamic routes, it returns the route
     * @return $array return an associative array containing the route and the parameters value
     */
    private function isADynamicRoute(string $route){
        foreach($this->dynamicRoutes as $dynamicRoute){
            // we split every part of both the urls
            $dynamicRouteParts = explode("/", $dynamicRoute);
            $routeParts = explode("/", $route);
            // we remove matching element to only get the parameters part
            $dynamicRouteParameters = array_diff($dynamicRouteParts, $routeParts);
            $routeParameters = array_diff($routeParts, $dynamicRouteParts);
            // if there is not the same amount of element the two urls doesn't match
            if(count($dynamicRouteParameters) != count($routeParameters)){
                continue;
            }
            return array(
                'route' => $dynamicRoute,
                'parameters' => $routeParameters,
            );
        }
        return false;
    }

    function __destruct()
    {
        $this->resolve();
    }
}
