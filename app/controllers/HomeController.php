<?php
namespace Ralph\Comic\Controllers;

use Bird\Ralph\Engine as View;

class HomeController{

    public function index()
    {
        return View::view('auth.login');
    }

    public function auth()
    {
        echo("logged");
    }
}