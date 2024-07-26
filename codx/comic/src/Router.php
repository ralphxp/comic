<?php
namespace Codx\Comic;

use Codx\Comic\Request;

use Codx\Ralph\Engine as View;

class Router{
    private $routes = [];
    private $auth_routes = [];
    private $params = [];

    public function routeParser($code)
    {
        $code = $this->parseAuth($code);
        $code = $this->parseGet($code);
        $code = $this->parsePost($code);
        $code = $this->parsePut($code);
        $code = $this->parseDelete($code);
        $this->dispatch();
    }

    public function parseAuth($code)
    {
        preg_match_all('/@auth(.+?)@endauth/s', $code, $matches, PREG_SET_ORDER);
        foreach($matches as $match)
        {
            $acode = $match[1];
            $acode = $this->parseGet($acode, true);
            $acode = $this->parsePost($acode, true);
        }
        
        
        $code = preg_replace('/@auth(.+?)@endauth/s', '', $code);

        return $code;
    }


    public function parseGet($code, $auth=false)
    {
        preg_match_all('/@get\s*\([\s*\"\'](.+?)[\s*\"\']\)(.+?)@end/s', $code, $matches, PREG_SET_ORDER);
        foreach($matches as $route)
        {
            $path = $route[1];
            $handler = $this->parseController($route[2]);
            $this->addRoute('GET', $path, $handler, $auth);
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

    public function parsePut($code)
    {
        preg_match_all('/@put\s*\([\s*\"\'](.+?)[\s*\"\']\)(.+?)@end/s', $code, $matches, PREG_SET_ORDER);
        foreach($matches as $route)
        {
            $path = $route[1];
            $controller = $this->parseController($route[2]);
            $file =  Core::parseAtFile($code);
            $this->put($path, $controller);
        }
        return $code;
    }

    public function parseDelete($code)
    {
        preg_match_all('/@delete\s*\([\s*\"\'](.+?)[\s*\"\']\)(.+?)@end/s', $code, $matches, PREG_SET_ORDER);
        foreach($matches as $route)
        {
            $path = $route[1];
            $controller = $this->parseController($route[2]);
            $file =  Core::parseAtFile($code);
            $this->delete($path, $controller);
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
    public function get($path, $handler)
    {
        
        $this->addRoute('GET', $path, $handler);
    }

    // Register a POST route
    public function post($path, $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put($path, $handler)
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete($path, $handler)
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute($method, $path, $handler, $auth=false)
    {
        $segments = explode('/', trim($path, '/'));
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'segments' => $segments,
            'auth'      => $auth
        ];
    }

    public function parseParams($uri){
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes[$method] as $route => $routeData) {
            $routeSegments = $routeData['segments'];
            $isAuth = $routeData['auth'];
            // ;
            // die(
            //     var_dump($ms)
            // );
            // if($isAuth){
                if (count($routeSegments) != count(explode('/', trim($path, '/')))) {
                    continue;
                }

                $matches = [];

                
                foreach ($routeSegments as $index => $segment) {
                    preg_match_all('/\{(.*?)\}/i', $segment, $ms, PREG_SET_ORDER);
                  
                    if (!empty($segment) && $segment[0] == '{' && $segment[strlen($segment) - 1] == '}') {
                        // Parameter segment, capture value
                        $paramName = substr($segment, 1, -1);
                        $matches[$paramName] = explode('/', trim($path, '/'))[$index];
                    } elseif ($segment != explode('/', trim($path, '/'))[$index]) {
                        // Static segment, no match
                        continue 2;
                    }
                }


                $handler = $routeData['handler'];
                foreach($matches as $param => $value)
                {
                    $_REQUEST[$param] = $value;
                }
                $this->callHandler($handler, $routeData['auth']);
            // }else{
            //     $handler = $routeData['handler'];
            //     $this->callHandler($handler);
            // }
            
            return;
        }

        http_response_code(404);
        // View::view('404');
        return;
    }

    // Dispatch the incoming request
    public function dispatch()
    {
       
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->parseParams($uri);
        die();
        // if (isset($this->routes[$method][$uri])) {
            
        //     $handler = $this->routes[$method][$uri];
        //     $this->callHandler($handler);
        // } else {
        //     // Handle 404 Not Found
        //     http_response_code(404);
        //     View::view('404');
        // }
    }

    // Call the specified handler (controller method)
    private function callHandler($handler, $auth)
    {
        
        // Split the handler into controller and method
        list($controller, $method) = explode('@', $handler);

        // Include the controller file
        $controllerFile = CONTROLLER_PATH . '/' . $controller . '.php';
        // echo $controllerFile;
        if (file_exists($controllerFile)) {
            // require_once $controllerFile;

            // Create an instance of the controller
            $namespace = 'Codx\\Comic\\Controller';
            $namespace .= '\\'.$controller;
            $controllerInstance = new $namespace();

            // Call the specified method
            $controllerInstance->$method(new Request);
        } else {
            // Handle 500 Internal Server Error
            http_response_code(500);
            echo '500 Internal Server Error';
            throw new \Exception("Error Processing Request");
            
        }
    }

}

