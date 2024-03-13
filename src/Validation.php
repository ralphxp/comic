<?php
namespace Codx\comic;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validation extends ValidatorInterface
{
    public static function validateRequired($params, $requiredParams)
    {
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new Exception("'$param' parameter is required", 400);
            }
        }
    }

    public static function validateInt($params, $intParams)
    {
        foreach ($intParams as $param) {
            if (isset($params[$param]) && !ctype_digit($params[$param])) {
                throw new Exception("'$param' parameter must be an integer", 400);
            }
        }
    }

    public static function validateString($params, $stringParams)
    {
        foreach ($stringParams as $param) {
            if (isset($params[$param]) && !is_string($params[$param])) {
                throw new Exception("'$param' parameter must be a string", 400);
            }
        }
    }

    // Add more validation methods as needed...
}
