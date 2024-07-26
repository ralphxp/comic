<?php
namespace Codx\Comic;


class Request
{

    private $method;
    private $uri;
    private $headers;
    private $queryParams;
    private $body;
    private $files;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->headers = getallheaders();
        $this->queryParams = $_REQUEST;
        $this->body = json_decode(file_get_contents('php://input'), true);
        $this->files = $_FILES;
        
        foreach ($this->queryParams as $param => $value) {
            $this->$param = $value;
        }
        foreach ($this->body as $param => $value) {
            $this->$param = $value;
            $this->queryParams[$param]  =  $value;
        }

    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function all()
    {
        return $this->queryParams;
    }

    public function files()
    {
        return $this->files;
    }

}
