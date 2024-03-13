<?php
namespace Codx\Comic;

class Bootstrap{

    public function start(){
        
        if(file_exists(ROOT.'/public/index.php')){
            $content = file_get_contents(ROOT.'/public/index.php');
            file_put_contents(CACHE_PATH.'/index.php', $content);

            require(CACHE_PATH.'/index.php');
        }
    }
}