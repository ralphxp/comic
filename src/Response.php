<?php
namespace Codx\Comic;

use Symfony\Component\HttpFoundation\Response as Responses; 
class Response extends Responses
{
    private $statusCode;
    private $headers;
    private $body;

    public function __construct()
    {
        $this->statusCode = 200;
        $this->headers = [];
        $this->body = '';
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function send()
    {
        // Set status code
        http_response_code($this->statusCode);

        // Set headers
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Send body
        echo $this->body;
    }
}
