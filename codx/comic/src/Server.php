<?php
namespace Codx\Comic;


class Server{

    static function runServer($argv){
       
        if(count($argv) > 2)
        {
            if(array_search('-p', $argv) && array_search('-h', $argv)){
                $p_index = array_search('-p', $argv);
                $h_index = array_search('-h', $argv);
                
                if(array_key_exists($p_index+1, $argv)){

                    $port = $argv[$p_index + 1];

                    if(array_key_exists($h_index+1, $argv)){
                        $host = $argv[$h_index + 1];
                        exec('php -S '.$host.':'.$port);
                        
                    }else{
                        
                        throw new \Exception("Error Host has no value");
                        
                    }
                    
                }else{
        
                    throw new \Exception("Error Port has no value");
                    
                }
            }
            // check for -p (port) arg
            else if(array_search('-p', $argv)){
                $index = array_search('-p', $argv);
                
                
                if(array_key_exists($index+1, $argv)){
                    $value = $argv[$index + 1];
                    exec('php -S '.$_ENV["HOST"].':'.$value);
                    
                }else{
                    throw new \Exception("Error Port has no value");
                    
                }
            }
            // check for -h (host) arg
            else if(array_search('-h', $argv)){
                $index = array_search('-h', $argv);
                
                
                if(array_key_exists($index+1, $argv)){
                    $value = $argv[$index + 1];
                    exec('php -S '.$value.':'.$_ENV['PORT']);
                    
                }else{
                    throw new \Exception("Error Port has no value");
                    
                }
            }

        }else{
            exec('php -S '.$_ENV["HOST"].':'.$_ENV['PORT']);
        }
    }
}
