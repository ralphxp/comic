<?php

use Ralph\Comic\HomeController;

@get("/")
    @controller("HomeController@index")
@end

@post('/')
    @controller("HomeController@auth")
@end
