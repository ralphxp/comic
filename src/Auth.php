<?php

namespace Codx\Comic;



class Auth
{
    public static function login($user)
    {
       
        if (!empty($user)) {
            $_SESSION['authenticated'] = true;
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public static function logout()
    {
       
        session_unset();
        session_destroy();
        return true;
    }

    public static function isAuthenticated()
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
    }

    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }
}
