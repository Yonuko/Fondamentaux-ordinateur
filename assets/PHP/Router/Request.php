<?php
include_once 'IRequest.php';

class Request implements IRequest
{
    function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getBody()
    {
        if ($this->requestMethod === "GET") {
            return;
        }

        if ($this->requestMethod == "POST") {
            $body = array();
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }

    /**
     * This method send an HTTP request of the given method
     * @param string $url the url to send the request
     * @param string $method the name of the method you want to use
     * @param array $data list of content you want to send
     * @return $content the return of the request
     */
    public static function send(string $url, string $method, array $data){
        $content = http_build_query($data);
        $context = stream_context_create (array (
            'http' => array (
                'method' => strtoupper($method),
                'content' => $content,
            ),
        ));
        $result = file_get_contents($url, null, $context);
        return $result;
    }
}
