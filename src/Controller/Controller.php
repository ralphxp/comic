<?php
namespace Codx\Comic\Controller;

use Codx\Comic\Api;
use Codx\Comic\Auth;
use Codx\Comic\Request;

class Controller
{

    public function __construct($auth = false)
    {

    }

    public function needAuth()
    {


        if (!Auth::isAuthenticated()) {

            header('location: /login');
        }
    }

    public function validate($array, $field)
    {
        return true;
    }

    public function APIKEY_Validate()
    {

        $headers = apache_request_headers();
        $token = $headers['token'];
        if (!$token) {
            return Api::sendError(['message' => 'invalid origin']);
        }


    }

}