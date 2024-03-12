<?php
require_once 'vendor/autoload.php';
require 'src/config/app.php';

use Ralph\Comic\Bootstrap as App;

$app = new App();

$app->start();