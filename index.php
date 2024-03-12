<?php
require_once 'vendor/autoload.php';
require 'src/config/app.php';

use Codx\Comic\Bootstrap as App;

$app = new App();

$app->start();