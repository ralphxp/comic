<?php
namespace Codx\Comic;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Codx\Comic\Router;

class Core{

// 
    public static function runApp()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'rental_house',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        


        if(file_exists(ROUTE_PATH.ROUTE_ENTRY)){
            $content = file_get_contents(ROUTE_PATH.ROUTE_ENTRY);
            self::registerRoutes($content);
        }
        else{
            
            if(is_dir( ROUTE_ENTRY)){
                file_put_contents(ROUTE_PATH.ROUTE_ENTRY, '<?php');
            }else{
                mkdir(ROUTE_PATH.ROUTE_ENTRY);
                file_put_contents(ROUTE_PATH.ROUTE_ENTRY, '<?php');
            }

            $content = file_get_contents(ROUTE_PATH.ROUTE_ENTRY);
            self::registerRoutes($content);
        }
    }


    public static function registerRoutes($content){

        
        $code = self::parsePhp($content);

        $router = new Router;
        $router->routeParser($code);
        
    }

    public static function parseAtFile($code)
    {
        preg_match_all('/@file\([\'\"\s*](.+?)[\'\"\s*]\)/i', $code, $matches, PREG_SET_ORDER);
        // echo($matches[0][count($matches[0]) - 1]);
        // die();
        return $code;
    }

    

    public static function parsePhp($code)
    {
        $code = str_replace("@php", "<?php", $code);
        $code = str_replace("@endphp", "?>", $code);
        return $code;
    }

    public static function requireFile($file)
    {
        require $file;
    }



}