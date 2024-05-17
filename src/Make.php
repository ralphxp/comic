<?php
namespace Codx\Comic;

class Make{

    protected static $controllerPath = __DIR__.DIRECTORY_SEPARATOR.'/../app/controllers/';

    // protected static $modelPath = getcwd().'/app/models/';

    protected static $tempDirectory = __DIR__.'/tmp/';


    static function make($query, $argv)
    {
        $query = strtolower($query);
        switch ($query) {
            case 'model':
                if(array_key_exists(2, $argv))
                {
                    self::makeModel($argv[2]);
                }else{
                    throw new \Exception("Error Processing Request, Model name is required");
                    
                }
                break;
            
            case 'controller':
                if(array_key_exists(2, $argv))
                {
                    self::makeController($argv[2]);
                }else{
                    throw new \Exception("Error Processing Request, Controller name is required");
                    
                }
                break;
            
            case 'route':
                if(array_key_exists(2, $argv))
                {
                    self::makeRoute($argv[2]);
                }else{
                    throw new \Exception("Error Processing Request, Controller name is required");
                    
                }
                break;
            
            default:
                # code...
                break;
        }
    }

    static function makeModel($name)
    {
        $name = strtoupper(substr($name, 0, 1)).substr($name, 1);
        $nameEx = $name;
        $name = $name.'.php';
        $filename = getcwd().'/app/models/'.$name;
        
        if(!file_exists($filename))
        {
            $handle = fopen($filename, 'w');
            fwrite($handle, '');
            fclose($handle);
            $temp = file_get_contents(self::$tempDirectory.'model.ralph');
            $temp = preg_replace('/ModelName/', $nameEx, $temp);
            $temp = preg_replace('/table_name/', strtolower($nameEx).'s', $temp);
            file_put_contents($filename, $temp);
            echo "Model ($nameEx) Successfully Created";
            
        }else{
            echo "$name Already exist in ".self::$modelPath;
        }

    }

    static function makecontroller($name)
    {
        $name = strtolower($name);
        $spr = preg_split('/(controller)/', $name);
        $name = $spr[0];
        $name = strtoupper(substr($name, 0, 1)).substr($name, 1);
        $nameEx = $name.'Controller';
        $name = $name.'Controller.php';
        $filename = getcwd().'/app/controllers/'.$name;
        
        if(!file_exists($filename))
        {
            $handle = fopen($filename, 'w');
            fwrite($handle, '');
            fclose($handle);
            $temp = file_get_contents(self::$tempDirectory.'controller.ralph');
            $temp = preg_replace('/ControllerName/', $nameEx, $temp);
            file_put_contents($filename, $temp);
            echo "controller ($nameEx) Successfully Created";
            
        }else{
            echo "$name Already exist in ".self::$controllerPath;
        }
    }

    static function makeRoute($name)
    {
        
    }
}