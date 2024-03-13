<?php
namespace Codx\Comic;


class Exception
{
    public static function handle(Exception $exception)
    {
        $statusCode = $exception->getCode() ?: 500;
        $message = $exception->getMessage() ?: 'Internal Server Error';
        API::sendError($message, $statusCode);
    }
}
