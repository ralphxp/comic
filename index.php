<?php
require 'config/app.php';
require_once 'vendor/autoload.php';


use Codx\Comic\Bootstrap as App;

$app = new App();

$app->start();