<?php 
namespace Codx\Comic;



class API
{
    public static function sendResponse($data, $status = 200)
    {
        self::setCorsHeaders();
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function sendError($message, $status = 500)
    {
        self::setCorsHeaders();
        self::sendResponse(['error' => $message], $status);
    }

    public static function handleRequest($callback)
    {
        try {
            self::setCorsHeaders();
            $data = call_user_func($callback);
            self::sendResponse($data);
        } catch (Exception $e) {
            self::sendError($e->getMessage());
        }
    }

    private static function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');
        header('Access-Control-Max-Age: 3600'); // Cache preflight request for 1 hour
    }
}
