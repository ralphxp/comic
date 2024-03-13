<?php
namespace Codx\Comic;

use Symfony\Component\HttpFoundation\Request as Requests;

class Request extends Requests{
    private $method;
    private $uri;
    private $headers;
    private $queryParams;
    private $body;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->headers = getallheaders();
        $this->queryParams = $_GET;
        $this->body = file_get_contents('php://input');
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
}
