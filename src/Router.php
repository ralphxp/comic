<?php
namespace Ralph\Comic;

use Ralph\Comic\HomeController;

class Router{
    private $routes = [];

    public function routeParser($code)
    {
        $
        $code = $this->parseGet($code);
        $code = $this->parsePost($code);
       
        // file_put_contents(CACHE_PATH.'/route.php', $code);
        // self::requireFile(CACHE_PATH.'/route.php');
        $this->dispatch();
    }

    public function parseGet($code)
    {
        preg_match_all('/@get\s*\([\s*\"\'](.+?)[\s*\"\']\)(.+?)@end/s', $code, $matches, PREG_SET_ORDER);
        foreach($matches as $route)
        {
            $path = $route[1];
            $controller = $this->parseController($route[2]);
            $this->get($path, $controller);
        }
        return $code;
    }

    public function parsePost($code)
    {
        preg_match_all('/@post\s*\([\s*\"\'](.+?)[\s*\"\']\)(.+?)@end/s', $code, $matches, PREG_SET_ORDER);
        foreach($matches as $route)
        {
            $path = $route[1];
            $controller = $this->parseController($route[2]);
            $file =  Core::parseAtFile($code);
            $this->post($path, $controller);
        }
        return $code;
    }

    public function parseController($code)
    {
        preg_match_all('/@controller\([\s*\"\']*(.+?)[\s*\"\']\)/s', $code, $matches, PREG_SET_ORDER);

        if(count($matches) > 0)
        {
            $code = $matches[0][1];
            
        }
        return $code;
    }

    // Register a GET route
    public function get($route, $handler)
    {
        $this->routes['GET'][$route] = $handler;
    }

    // Register a POST route
    public function post($route, $handler)
    {
        $this->routes['POST'][$route] = $handler;
    }

    // Dispatch the incoming request
    public function dispatch()
    {
       
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // die($uri);
        // Check if the requested route is registered
        if (isset($this->routes[$method][$uri])) {
            // If yes, call the associated handler
            $handler = $this->routes[$method][$uri];
            $this->callHandler($handler);
        } else {
            // Handle 404 Not Found
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    // Call the specified handler (controller method)
    private function callHandler($handler)
    {
        // Split the handler into controller and method
        list($controller, $method) = explode('@', $handler);

        // Include the controller file
        $controllerFile = CONTROLLER_PATH . '/' . $controller . '.php';
        // echo $controllerFile;
        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            // Create an instance of the controller
            $namespace = 'Ralph\\Comic\\Controllers';
            $namespace .= '\\'.$controller;
            $controllerInstance = new $namespace;

            // Call the specified method
            $controllerInstance->$method();
        } else {
            // Handle 500 Internal Server Error
            http_response_code(500);
            echo '500 Internal Server Error';
            throw new \Exception("Error Processing Request");
            
        }
    }

}