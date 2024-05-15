<?php
namespace Codx\Comic\Controller;

use Codx\Comic\Auth;

class Controller{

    public function __construct($auth=false)
    {
        
    }

    public function needAuth()
    {
        
        
        if(!Auth::isAuthenticated())
        {

            header('location: /login');
        }
    }

}