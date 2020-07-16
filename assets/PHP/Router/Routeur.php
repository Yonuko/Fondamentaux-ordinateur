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

    function getRequest(){
        return $this->request;
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
        include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/404.php");
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
            if($this->request->requestMethod === "POST"){
                array_unshift($dynamicRoute['parameters'], $this->request);
            }
            echo call_user_func_array($method, $dynamicRoute['parameters']);
            return;
        }

        if (!isset($methodDictionary[$formatedRoute])) {
            echo "requested url : " . $this->request->requestUri;
            echo "<br>formated route : " . $formatedRoute . "<br>";
            echo "method : " . $this->request->requestMethod . "<br>";
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
            $dynamicRouteParameters = $this->compareSplits($dynamicRouteParts, $routeParts);
            $routeParameters = $this->compareSplits($routeParts, $dynamicRouteParts);
            // if there is an element that is not a parameters then we continue the loop
            $matches = array_filter($dynamicRouteParameters, function($var){
                return (boolean)preg_match("/}/", $var);
            });
            $parametersNumbers = array_filter($routeParameters, function($var){
                return (boolean)is_numeric($var);
            });
            if(count($matches) !== count($dynamicRouteParameters) || 
            count($parametersNumbers) !== count($routeParameters)){
                continue;
            }
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

    /**
     * This function return the differences between the two given array in order (compared to array_diff)
     * ex : array("projects", "{id}"), array("projects", "1") will return array("{id}") but
     *      array("projects", "{id}"), array("1", "projects") will return array("projects", "{id}")
     * @param array $array1 first array to compare
     * @param array $array2 second array to compare
     * @return array an array containing all the entries from array1 that are not present in the other array
     */
    private function compareSplits(array $array1, array $array2){
        $result = array();
        $loopCount = (count($array1) > count($array2)) ? count($array2) : count($array1);
        for($i = 0; $i < $loopCount; $i++){
            if($array1[$i] !== $array2[$i]){
                array_push($result, $array1[$i]);
            }
        }
        if(count($array1) > count($array2)){
            for($i = $loopCount; $i < count($array1); $i++){
                array_push($result, $array1[$i]);
            }
        }
        return $result;
    }

    function __destruct()
    {
        $this->resolve();
    }
}
