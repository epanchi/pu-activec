<?php

include('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
var_dump($dotenv->load());